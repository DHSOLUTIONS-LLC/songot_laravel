<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'user_id', 'guest_session_id', 'stem_id', 'ip_hash',
        'user_agent', 'downloaded_at', 'source_type', 'status'
    ];

    protected $casts = [
        'downloaded_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stem()
    {
        return $this->belongsTo(Stem::class);
    }

    // Scope for rate limiting queries
    public function scopeRecent($query, $minutes = 15)
    {
        return $query->where('downloaded_at', '>=', now()->subMinutes($minutes));
    }
}