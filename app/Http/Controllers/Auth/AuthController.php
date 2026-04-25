<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // ── Show Login (redirect to SPA) ──
public function showLogin()
{
    return view('auth.login');  // direct blade view
}

    // ── Show Register (redirect to SPA) ──
public function showRegister()
{
    return view('auth.register');  // direct blade view
}

    // ── Handle Login ──
 public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // Find user by email
    $user = User::where('email', $request->email)->first();

    // Check password using password_hash field
    if (!$user || !Hash::check($request->password, $user->password_hash)) {
        return back()->withErrors([
            'email' => 'Invalid credentials. Please check your email and password.',
        ])->onlyInput('email');
    }

    // Check if user is banned
    if ($user->status !== 'active') {
        return back()->withErrors([
            'email' => 'Your account is ' . $user->status . '. Please contact support.',
        ])->onlyInput('email');
    }

    // Login the user
    Auth::login($user, $request->boolean('remember'));
    
    // Update last login time
    $user->update(['last_login_at' => now()]);

    // Redirect based on role
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->intended('/')->with('success', 'Welcome back, ' . $user->name . '!');
}

public function logout(Request $request)
{
    // Clear all session data on logout
    $request->session()->forget(['guest_downloads', 'guest_session_id', 'download_count']);
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect('/')->with('info', 'Logged out successfully');
}

public function register(Request $request)
{
    // Validate
    $request->validate([
        // 'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

     $name = explode('@', $request->email)[0];
    
    // Create user
    $user = User::create([
        'name' => $name,
        'email' => $request->email,
        'password_hash' => Hash::make($request->password),
    ]);
    
    // Login the user
    Auth::login($user);
    
    $selectedPlan = $request->input('selected_plan');
    
    if ($selectedPlan && in_array($selectedPlan, ['web', 'full'])) {
        // ✅ Yeh line change karo - direct checkout page pe bhejo
        return redirect()->to('/checkout-page?plan=' . $selectedPlan);
    }

    return redirect()->to('/');
}

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // ── Google OAuth: Callback ──
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Google login failed. Please try again.');
        }

        // User dhundo ya banao
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'       => $googleUser->getName(),
                'role'       => 'user',
                'status'     => 'active',
                'plan_tier'  => 'free',
            ]
        );

        // Agar pehle email/password se register kiya tha — google id add karo
        if (!$user->google_id) {
            $user->update(['google_id' => $googleUser->getId()]);
        }

        if (in_array($user->status, ['banned', 'suspended'])) {
            return redirect('/')->with('error', 'Account suspend hai.');
        }

        Auth::login($user);
        $user->update(['last_login_at' => now()]);
        request()->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/')->with('success', 'Welcome, ' . $user->name . '!');
    }
}