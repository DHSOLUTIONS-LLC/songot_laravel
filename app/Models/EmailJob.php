<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailJob extends Model
{
    protected $fillable = [
        'subject', 'body', 'recipient_scope',
        'created_by', 'status', 'sent_count', 'failed_count'
    ];
    
    protected $casts = [
        'recipient_scope' => 'array'
    ];
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}