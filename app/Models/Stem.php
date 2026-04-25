<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'artist', 'stem_type', 'bpm', 'musical_key',
        'genre', 'storage_path', 'preview_path', 'duration',
        'is_visible', 'is_free', 'is_locked', 'uploaded_from_job_id'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'is_free' => 'boolean',
        'is_locked' => 'boolean',
        'bpm' => 'integer',
        'duration' => 'integer',
    ];

    // Accessor for full URL
    public function getAudioUrlAttribute(): string
    {
        return Storage::disk('s3')->temporaryUrl(
            $this->storage_path, now()->addMinutes(15)
        );
    }

    public function getPreviewUrlAttribute(): string
    {
        if ($this->preview_path) {
            return Storage::disk('s3')->temporaryUrl(
                $this->preview_path, now()->addMinutes(15)
            );
        }
        return $this->audio_url; // fallback to full audio
    }

    // Check if user can download this stem
    public function canUserDownload($user): bool
    {
        // Admin can download anything
        if ($user && $user->isAdmin()) return true;
        
        // If stem is locked, only paid users can download
        if ($this->is_locked) {
            return $user && $user->hasWebAccess();
        }
        
        // Free stems are downloadable by anyone
        return true;
    }

    // Scope for visible stems
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    // Scope for free stems (first 200 or is_free true)
    public function scopeFreeAccess($query)
    {
        return $query->where(function($q) {
            $q->where('is_free', true)
              ->orWhere('id', '<=', 200);
        })->where('is_locked', false);
    }

    // Relationships
    public function downloads()
    {
        return $this->hasMany(Download::class);
    }


    // Scope for paid access (web and full tier)
    public function scopePaidAccess($query)
    {
        return $query->where('is_visible', true);
    }
}