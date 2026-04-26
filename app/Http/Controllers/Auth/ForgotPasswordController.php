<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    // ──────────────────────────────────────────────
    // STEP 1 – Send OTP
    // POST /api/forgot-password/send-otp
    // ──────────────────────────────────────────────
    public function sendOtp(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = strtolower(trim($request->email));

        // Rate-limit: max 3 OTP requests per email per 10 min
        $rateLimitKey = 'otp-send:' . $email;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return response()->json([
                'success' => false,
                'message' => "Too many requests. Please wait {$seconds} seconds before trying again.",
            ], 429);
        }
        RateLimiter::hit($rateLimitKey, 600); // 10-minute decay

        // Always respond with success even if email not found (security best practice)
        $user = User::where('email', $email)->first();

        if ($user) {
            // Invalidate previous OTPs for this email
            PasswordResetOtp::where('email', $email)->delete();

            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            PasswordResetOtp::create([
                'email'      => $email,
                'otp'        => $otp,
                'expires_at' => now()->addMinutes(10),
            ]);

            Mail::to($email)->send(new PasswordResetOtpMail($otp, $user->name));

            return response()->json([
                'success' => true,
                'message' => 'If an account with that email exists, a reset code has been sent.',
            ]);
        }

        return response()->json([
                'success' => false,
                'message' => 'Account not found.',
        ]);
    }

    // ──────────────────────────────────────────────
    // STEP 2 – Verify OTP
    // POST /api/forgot-password/verify-otp
    // ──────────────────────────────────────────────
    public function verifyOtp(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp'   => ['required', 'string', 'size:6'],
        ]);

        $email = strtolower(trim($request->email));

        // Rate-limit OTP attempts: max 5 per email per 15 min
        $rateLimitKey = 'otp-verify:' . $email;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            return response()->json([
                'success' => false,
                'message' => 'Too many failed attempts. Please request a new code.',
            ], 429);
        }

        $record = PasswordResetOtp::where('email', $email)
            ->where('verified', false)
            ->latest()
            ->first();

        if (!$record || !$record->isValid($request->otp)) {
            RateLimiter::hit($rateLimitKey, 900);
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired code. Please try again.',
            ], 422);
        }

        // Mark OTP as verified and issue a short-lived reset token
        $resetToken = Str::random(64);
        $record->update([
            'verified'    => true,
            'reset_token' => $resetToken,
            'expires_at'  => now()->addMinutes(15), // token valid for 15 min
        ]);

        RateLimiter::clear($rateLimitKey);

        return response()->json([
            'success'     => true,
            'message'     => 'Code verified successfully.',
            'reset_token' => $resetToken,
        ]);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email'                 => ['required', 'email'],
            'reset_token'           => ['required', 'string'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        $email = strtolower(trim($request->email));

        $record = PasswordResetOtp::where('email', $email)
            ->where('reset_token', $request->reset_token)
            ->where('verified', true)
            ->first();

        if (!$record || $record->isExpired()) {
            return response()->json([
                'success' => false,
                'message' => 'Reset session expired. Please start over.',
            ], 422);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Account not found.',
            ], 404);
        }

        $user->update([
            'password_hash' => Hash::make($request->password),
        ]);

        $record->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully. You can now sign in.',
        ]);
    }
}