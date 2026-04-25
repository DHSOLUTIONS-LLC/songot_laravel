<?php
// app/Models/VaultGenreMeta.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaultGenreMeta extends Model
{
    protected $table = 'vault_genre_meta';

    protected $fillable = [
        'genre_id',
        'description',
        'tags',
        'is_hidden',
    ];

    protected $casts = [
        'tags'      => 'array',
        'is_hidden' => 'boolean',
    ];
}