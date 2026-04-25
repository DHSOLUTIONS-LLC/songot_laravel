<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Webhook;

class PaymentController extends Controller
{
    public function __construct()
    {
        // YEH IMPORTANT HAI - API key set karo
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function checkout(Request $request)
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Please login first'], 401);
        }

        $tier = $request->tier; // 'web' or 'full'
        
        $prices = [
            'web' => 3500,  // $35.00
            'full' => 14900, // $149.00 (ya $5500 agar $55 hai to)
        ];

        $tierNames = [
            'web' => 'Web Access',
            'full' => 'Full Library Package',
        ];

        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $tierNames[$tier],
                        'description' => 'One-time payment for ' . $tierNames[$tier],
                    ],
                    'unit_amount' => $prices[$tier],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
            'metadata' => [
                'user_id' => $user->id,
                'tier' => $tier,
            ],
        ]);

        // Save purchase record
        Purchase::create([
            'user_id' => $user->id,
            'stripe_session_id' => $checkoutSession->id,
            'product_type' => $tier,
            'amount' => $prices[$tier] / 100,
            'status' => 'pending',
        ]);

        return response()->json([
            'session_id' => $checkoutSession->id,
            'checkout_url' => $checkoutSession->url,
        ]);
    }

    // Success page
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        // Retrieve session from Stripe
        $session = Session::retrieve($sessionId);
        
        // Update purchase status
        $purchase = Purchase::where('stripe_session_id', $sessionId)->first();
        if ($purchase) {
            $purchase->update([
                'status' => 'completed',
                'stripe_payment_intent_id' => $session->payment_intent,
                'purchased_at' => now(),
            ]);
            
            // Update user tier
            $user = User::find($purchase->user_id);
            $user->update(['plan_tier' => $purchase->product_type]);
        }
        
        return view('payment.success', ['tier' => $purchase->product_type ?? 'web']);
    }

    // Cancel page
    public function cancel()
    {
        return view('payment.cancel');
    }

    // Webhook handler
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Exception $e) {
            Log::error('Webhook signature verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            
            $purchase = Purchase::where('stripe_session_id', $session->id)->first();
            if ($purchase && $purchase->status !== 'completed') {
                $purchase->update([
                    'status' => 'completed',
                    'stripe_payment_intent_id' => $session->payment_intent,
                    'purchased_at' => now(),
                ]);
                
                $user = User::find($purchase->user_id);
                $user->update(['plan_tier' => $purchase->product_type]);
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function subscribeFree(Request $request)
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Please login first'], 401);
        }
        
        $user->update(['plan_tier' => 'free']);
        
        return response()->json([
            'success' => true,
            'message' => 'You are now on the Free plan',
            'plan' => 'free'
        ]);
    }
}