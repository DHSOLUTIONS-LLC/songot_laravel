<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'stripe_session_id', 'stripe_payment_intent_id',
        'product_type', 'amount', 'status', 'purchased_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'purchased_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Complete purchase and upgrade user tier
    public function complete(): void
    {
        $this->update([
            'status' => 'completed',
            'purchased_at' => now()
        ]);
        
        // Upgrade user tier based on product type
        $this->user->update([
            'plan_tier' => $this->product_type // 'web' or 'full'
        ]);
    }
}