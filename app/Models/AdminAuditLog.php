<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAuditLog extends Model
{
    protected $fillable = [
        'admin_user_id', 'action_type', 'target_type',
        'target_id', 'details'
    ];
    
    protected $casts = [
        'details' => 'array'
    ];
    
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }
}