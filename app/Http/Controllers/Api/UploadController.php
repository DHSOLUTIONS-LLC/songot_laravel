<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use getID3;
use Illuminate\Support\Facades\Cache;

class UploadController extends Controller
{
    // Single stem upload with BPM/Key detection
public function uploadSingle(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:200',
        'artist' => 'required|string|max:100',
        'stem_type' => 'required|string|in:Acapella,Drums,Bass,Melody,Instrumental',
        'bpm' => 'nullable|integer|min:40|max:220',
        'key' => 'nullable|string|max:10',
        'genre' => 'required|string|max:50',
        'file' => 'required|file|mimes:mp3,wav,ogg|max:51200',
        'job_id' => 'nullable|string',
    ]);

    DB::beginTransaction();

    try {
        $file = $request->file('file');
        
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $request->title) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('stems', $filename, 'public');
        $fullPath = storage_path('app/public/' . $path);
        
        $detectedBpm = $request->bpm;
        $detectedKey = $request->key;
        
        if (empty($detectedBpm)) {
            $detectedBpm = $this->detectBpm($fullPath);
        }
        
        if (empty($detectedKey)) {
            $detectedKey = $this->detectKey($fullPath);
        }
        
        $duration = $this->getAudioDuration($fullPath);
        
        // Create stem — always unlocked initially
        $stem = Stem::create([
            'title'                => $request->title,
            'artist'               => $request->artist,
            'stem_type'            => $request->stem_type,
            'bpm'                  => $detectedBpm ?: 120,
            'musical_key'          => $detectedKey ?: 'C Maj',
            'genre'                => $request->genre,
            'storage_path'         => $path,
            'duration'             => $duration,
            'is_visible'           => true,
            'is_locked'            => false,
            'uploaded_from_job_id' => $request->job_id,
        ]);

        // ============================================
        // REBALANCE LOCK STATUS AFTER EVERY UPLOAD
        // Keep the 200 most recent stems unlocked,
        // lock everything older.
        // ============================================
        $this->rebalanceLockStatus();

        DB::commit();
        Cache::forget('unlocked_stem_ids');
        
        return response()->json([
            'success' => true,
            'message' => 'Stem uploaded successfully',
            'stem'    => [
                'id'           => $stem->id,
                'title'        => $stem->title,
                'artist'       => $stem->artist,
                'stem_type'    => $stem->stem_type,
                'bpm'          => $stem->bpm,
                'key'          => $stem->musical_key,
                'genre'        => $stem->genre,
                'detected_bpm' => $detectedBpm,
                'detected_key' => $detectedKey,
                'audio_url'    => Storage::url($stem->storage_path),
            ]
        ], 201);
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        return response()->json([
            'success' => false,
            'message' => 'Upload failed: ' . $e->getMessage()
        ], 500);
    }
}

private function rebalanceLockStatus(): void
{
    // IDs of the 200 newest stems
    $recentIds = Stem::orderBy('id', 'desc')
        ->limit(200)
        ->pluck('id');

    // Unlock the 200 most recent
    Stem::whereIn('id', $recentIds)
        ->update(['is_locked' => false]);

    // Lock everything else
    Stem::whereNotIn('id', $recentIds)
        ->update(['is_locked' => true]);
}
    
    // Bulk upload with BPM/Key detection
    public function uploadBulk(Request $request)
    {
        $request->validate([
            'stems' => 'required|array',
            'stems.*.title' => 'required|string|max:200',
            'stems.*.artist' => 'required|string|max:100',
            'stems.*.stem_type' => 'required|string|in:Acapella,Drums,Bass,Melody,Instrumental',
            'stems.*.bpm' => 'nullable|integer',
            'stems.*.key' => 'nullable|string',
            'stems.*.genre' => 'required|string|max:50',
            'stems.*.file' => 'required|file|mimes:mp3,wav,ogg|max:51200',
            'job_id' => 'nullable|string',
        ]);
        
        $uploadedStems = [];
        $errors = [];
        
        DB::beginTransaction();
        
        try {
            foreach ($request->file('stems') as $index => $file) {
                $stemData = $request->stems[$index];
                
                // Store file
                $filename = time() . '_' . $index . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $stemData['title']) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('stems', $filename, 'public');
                $fullPath = storage_path('app/public/' . $path);
                
                // Auto-detect BPM and Key if not provided
                $detectedBpm = $stemData['bpm'] ?? $this->detectBpm($fullPath);
                $detectedKey = $stemData['key'] ?? $this->detectKey($fullPath);
                $duration = $this->getAudioDuration($fullPath);
                
                // Create stem record
                $stem = Stem::create([
                    'title' => $stemData['title'],
                    'artist' => $stemData['artist'],
                    'stem_type' => $stemData['stem_type'],
                    'bpm' => $detectedBpm ?: 120,
                    'musical_key' => $detectedKey ?: 'C Maj',
                    'genre' => $stemData['genre'],
                    'storage_path' => $path,
                    'duration' => $duration,
                    'is_visible' => true,
                    // 'is_free' => Stem::count() < 200,
                    // 'is_locked' => Stem::count() >= 200,
                    'uploaded_from_job_id' => $request->job_id,
                ]);
                
                $uploadedStems[] = $stem;
            }
            
            DB::commit();
            Cache::forget('unlocked_stem_ids');
            
            return response()->json([
                'success' => true,
                'message' => count($uploadedStems) . ' stems uploaded successfully',
                'stems' => $uploadedStems
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Detect BPM from audio file
     * Uses getID3 library to extract tempo information
     */
    private function detectBpm($filePath)
    {
        if (!file_exists($filePath)) {
            return null;
        }
        
        try {
            $getID3 = new getID3();
            $fileInfo = $getID3->analyze($filePath);
            
            // Try to get BPM from various metadata sources
            $bpm = null;
            
            // Check for tempo in ID3 tags
            if (isset($fileInfo['tags']['id3v2']['tempo'][0])) {
                $bpm = intval($fileInfo['tags']['id3v2']['tempo'][0]);
            } elseif (isset($fileInfo['tags']['id3v1']['tempo'][0])) {
                $bpm = intval($fileInfo['tags']['id3v1']['tempo'][0]);
            } elseif (isset($fileInfo['quicktime']['moov']['subatoms']['tmpo'])) {
                $bpm = intval($fileInfo['quicktime']['moov']['subatoms']['tmpo']);
            } elseif (isset($fileInfo['asf']['audio_content']['tempo'])) {
                $bpm = intval($fileInfo['asf']['audio_content']['tempo']);
            }
            
            // If BPM found, return it
            if ($bpm && $bpm >= 40 && $bpm <= 220) {
                return $bpm;
            }
            
            // Estimate BPM based on file analysis (simple algorithm)
            // This is a fallback - for production, use a proper BPM detection library
            return $this->estimateBpm($filePath);
            
        } catch (\Exception $e) {
            \Log::error('BPM detection failed: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Detect musical key from audio file
     */
    private function detectKey($filePath)
    {
        if (!file_exists($filePath)) {
            return null;
        }
        
        try {
            $getID3 = getID3::analyze($filePath);
            
            // Check for key in ID3 tags
            $key = null;
            
            if (isset($getID3['tags']['id3v2']['initialkey'][0])) {
                $key = $getID3['tags']['id3v2']['initialkey'][0];
            } elseif (isset($getID3['tags']['id3v1']['initialkey'][0])) {
                $key = $getID3['tags']['id3v1']['initialkey'][0];
            }
            
            // Clean up key format
            if ($key) {
                $key = $this->formatKey($key);
            }
            
            // If key found, return it
            if ($key) {
                return $key;
            }
            
            // Return default based on file hash (for demo purposes)
            // In production, use a proper key detection library
            return $this->estimateKey($filePath);
            
        } catch (\Exception $e) {
            \Log::error('Key detection failed: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Format musical key to standard format (e.g., "C Maj", "A Min")
     */
    private function formatKey($key)
    {
        $key = strtoupper(trim($key));
        
        // Remove common prefixes
        $key = str_replace(['KEY ', 'KEY_'], '', $key);
        
        // Map to standard format
        $keyMap = [
            'C' => 'C Maj', 'C#M' => 'C# Maj', 'DBM' => 'Db Maj', 'D' => 'D Maj',
            'D#M' => 'D# Maj', 'EBM' => 'Eb Maj', 'E' => 'E Maj', 'F' => 'F Maj',
            'F#M' => 'F# Maj', 'GBM' => 'Gb Maj', 'G' => 'G Maj', 'G#M' => 'G# Maj',
            'ABM' => 'Ab Maj', 'A' => 'A Maj', 'A#M' => 'A# Maj', 'BBM' => 'Bb Maj',
            'B' => 'B Maj', 'CM' => 'C Maj', 'DM' => 'D Maj', 'EM' => 'E Maj',
            'FM' => 'F Maj', 'GM' => 'G Maj', 'AM' => 'A Maj', 'BM' => 'B Maj',
            'Cm' => 'C Min', 'C#m' => 'C# Min', 'Dm' => 'D Min', 'D#m' => 'D# Min',
            'Em' => 'E Min', 'Fm' => 'F Min', 'F#m' => 'F# Min', 'Gm' => 'G Min',
            'G#m' => 'G# Min', 'Am' => 'A Min', 'A#m' => 'A# Min', 'Bm' => 'B Min',
        ];
        
        if (isset($keyMap[$key])) {
            return $keyMap[$key];
        }
        
        return $key;
    }
    
    /**
     * Estimate BPM (fallback method)
     */
    private function estimateBpm($filePath)
    {
        // Simple estimation based on file size and duration
        // For production, use a proper BPM detection algorithm
        $duration = $this->getAudioDuration($filePath);
        $fileSize = filesize($filePath);
        
        // Rough estimation: average song has 120 BPM
        // This is just a placeholder - use actual BPM detection in production
        $estimatedBpm = 100 + (intval($fileSize / 1000000) % 80);
        
        // Ensure BPM is within reasonable range
        return min(max($estimatedBpm, 60), 180);
    }
    
    /**
     * Estimate musical key (fallback method)
     */
    private function estimateKey($filePath)
    {
        $commonKeys = ['C Maj', 'G Maj', 'D Min', 'A Min', 'F Maj', 'E Min'];
        
        // Use file hash to deterministically pick a key
        $hash = md5_file($filePath);
        $index = hexdec(substr($hash, 0, 2)) % count($commonKeys);
        
        return $commonKeys[$index];
    }
    
    /**
     * Get audio duration using getID3
     */
    private function getAudioDuration($filePath)
    {
        if (!file_exists($filePath)) {
            return 180; // Default 3 minutes
        }
        
        try {
            $getID3 = new getID3();
            $fileInfo = $getID3->analyze($filePath);
            
            if (isset($fileInfo['playtime_seconds'])) {
                return intval($fileInfo['playtime_seconds']);
            }
            
            // Fallback: estimate from file size (128kbps = 16KB per second)
            $fileSize = filesize($filePath);
            return intval($fileSize / 16000);
            
        } catch (\Exception $e) {
            return 180;
        }
    }
}