<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10',
        ]);

        try {
            // Send email to admin/support
            Mail::send([], [], function ($mail) use ($request) {
                $mail->to(config('mail.support_email', 'support@songotsamples.com'))
                    ->subject('Contact Form: ' . $request->subject)
                    ->replyTo($request->email, $request->name)
                    ->html("
                        <h3>New Contact Message</h3>
                        <p><strong>From:</strong> {$request->name} ({$request->email})</p>
                        <p><strong>Subject:</strong> {$request->subject}</p>
                        <p><strong>Message:</strong></p>
                        <p>" . nl2br(e($request->message)) . "</p>
                    ");
            });

            // Send auto-reply to user
            Mail::send([], [], function ($mail) use ($request) {
                $mail->to($request->email)
                    ->subject('Thank you for contacting Son Got Samples')
                    ->html("
                        <h3>Thank you for reaching out!</h3>
                        <p>Dear {$request->name},</p>
                        <p>We have received your message and will get back to you within 24-48 hours.</p>
                        <p><strong>Your message:</strong><br>" . nl2br(e($request->message)) . "</p>
                        <br>
                        <p>Best regards,<br>Son Got Samples Team</p>
                    ");
            });

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent. We will respond within 24-48 hours.'
            ]);

        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message. Please try again later.'
            ], 500);
        }
    }
}