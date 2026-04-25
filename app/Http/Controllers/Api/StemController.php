<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stem;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use ZipArchive;
use Illuminate\Support\Facades\File;
class StemController extends Controller
{

private function getUnlockedStemIds(): array
{
    return Stem::where('is_visible', true)
        ->orderBy('created_at', 'asc')
        ->limit(200)
        ->pluck('id')
        ->toArray();
}

    // Get all stems
public function index(Request $request)
{
    try {
        $query = Stem::where('is_visible', true);

        // Search
        if ($request->input('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('artist', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('genre', 'like', '%' . $request->input('search') . '%');
            });
        }

        // Filter by type
        if ($request->input('stem_type') && $request->input('stem_type') !== 'All') {
            $query->where('stem_type', $request->input('stem_type'));
        }

        // Sort
        switch ($request->input('sort', 'recent')) {
            case 'bpmAsc':
                $query->orderBy('bpm', 'asc');
                break;
            case 'bpmDesc':
                $query->orderBy('bpm', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'genre':
                $query->orderBy('genre', 'asc');
                break;
            case 'key':
                $query->orderBy('musical_key', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $stems      = $query->paginate(20);
        $user       = Auth::user();
        $userTier   = $user?->plan_tier ?? 'free';
        $isLoggedIn = Auth::check();

        $stems->getCollection()->transform(function ($stem) use ($userTier, $isLoggedIn) {
            // web/full tier → always unlocked regardless of DB value
            if ($isLoggedIn && in_array($userTier, ['web', 'full'])) {
                $stem->is_locked = false;
            }
            // free user & guests → trust DB value set by rebalanceLockStatus()
            else {
                // is_locked is already correct from DB, no override needed
                // just leave $stem->is_locked as-is
            }

            return $stem;
        });

        // Guest downloads remaining
        $guestRemaining = null;
        if (!$isLoggedIn) {
            $ip             = $request->ip();
            $today          = date('Y-m-d');
            $cacheKey       = 'guest_downloads_' . md5($ip . $today);
            $count          = Cache::get($cacheKey, 0);
            $guestRemaining = max(0, 5 - $count);
        }

        return response()->json([
            'stems' => $stems,
            'user'  => [
                'is_logged_in'              => $isLoggedIn,
                'tier'                      => $userTier,
                'guest_downloads_remaining' => $guestRemaining,
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    // Get single stem
    public function show($id)
    {
        try {
            $stem        = Stem::where('id', $id)->where('is_visible', true)->firstOrFail();
            $unlockedIds = $this->getUnlockedStemIds();
            $userTier    = Auth::user()?->plan_tier ?? 'free';

            if (Auth::check() && in_array($userTier, ['web', 'full'])) {
                $stem->is_locked = false;
            } else {
                $stem->is_locked = !in_array($stem->id, $unlockedIds);
            }

            return response()->json($stem);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Stem not found'], 404);
        }
    }

    // Preview audio
public function preview($id)
{
    try {
        $stem = Stem::where('id', $id)->where('is_visible', true)->firstOrFail();

        $userTier   = Auth::user()?->plan_tier ?? 'free';
        $isLoggedIn = Auth::check();

        // web/full tier → always unlocked; everyone else → trust DB
        if ($isLoggedIn && in_array($userTier, ['web', 'full'])) {
            $isLocked = false;
        } else {
            $isLocked = (bool) $stem->is_locked;
        }

        if ($isLocked) {
            return response()->json(['error' => 'Stem is locked'], 403);
        }

        $pathsToTry = [
            storage_path('app/public/' . $stem->storage_path),
            public_path('storage/' . $stem->storage_path),
        ];

        $filePath = null;
        foreach ($pathsToTry as $path) {
            if (file_exists($path)) {
                $filePath = $path;
                break;
            }
        }

        if (!$filePath) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->file($filePath, ['Content-Type' => 'audio/mpeg']);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
public function download($id, Request $request)
{
    $stem = Stem::findOrFail($id);

    $userTier   = Auth::user()?->plan_tier ?? 'free';
    $isLoggedIn = Auth::check();

    // web/full tier → always unlocked; everyone else → trust DB
    if ($isLoggedIn && in_array($userTier, ['web', 'full'])) {
        $isLocked = false;
    } else {
        $isLocked = (bool) $stem->is_locked;
    }

    if ($isLocked) {
        return response()->json([
            'success'          => false,
            'message'          => 'This stem is locked.',
            'requires_account' => true
        ], 403);
    }

    // Guest download limit check
    if (!$isLoggedIn) {
        $ip       = $request->ip();
        $today    = date('Y-m-d');
        $cacheKey = 'guest_downloads_' . md5($ip . $today);
        $count    = Cache::get($cacheKey, 0);

        if ($count >= 5) {
            return response()->json([
                'success'             => false,
                'message'             => 'Daily download limit reached.',
                'requires_account'    => true,
                'remaining_downloads' => 0
            ], 429);
        }
    }

    // Rate limiting
    $rateLimitKey   = 'download_rate_' . $request->ip() . date('Y-m-d-H-i');
    $rateLimitCount = Cache::get($rateLimitKey, 0);

    if ($rateLimitCount >= 5) {
        return response()->json([
            'success'          => false,
            'message'          => 'Too many downloads. Please wait.',
            'cooldown_seconds' => 30
        ], 429);
    }

    Cache::put($rateLimitKey, $rateLimitCount + 1, now()->addMinutes(1));

    // Guest counter increment
    if (!$isLoggedIn) {
        $ip       = $request->ip();
        $today    = date('Y-m-d');
        $cacheKey = 'guest_downloads_' . md5($ip . $today);
        $count    = Cache::get($cacheKey, 0);
        Cache::put($cacheKey, $count + 1, now()->addHours(24));
    }

    // Log download
    Download::create([
        'user_id'       => Auth::id(),
        'stem_id'       => $stem->id,
        'ip_address'    => $request->ip(),
        'ip_hash'       => md5($request->ip()),
        'downloaded_at' => now()
    ]);

    // File path resolve
    $pathsToTry = [
        storage_path('app/public/' . $stem->storage_path),
        public_path('storage/' . $stem->storage_path),
        storage_path('app/public/stems/' . $stem->file_path),
        public_path('storage/stems/' . $stem->file_path),
    ];

    $filePath = null;
    foreach ($pathsToTry as $path) {
        if ($path && file_exists($path)) {
            $filePath = $path;
            break;
        }
    }

    if (!$filePath) {
        return response()->json([
            'success' => false,
            'message' => 'File not found on server.'
        ], 404);
    }

    $artist   = trim(preg_replace('/[^a-zA-Z0-9\s\-\.]/', '', $stem->artist   ?? 'Unknown Artist'));
    $title    = trim(preg_replace('/[^a-zA-Z0-9\s\-\.]/', '', $stem->title    ?? 'Unknown'));
    $stemType = trim($stem->stem_type ?? 'Track');
    $bpm      = $stem->bpm           ?? '0';
    $key      = $stem->musical_key   ?? '';

    $key = trim($key);

    if (preg_match('/major/i', $key)) {
        // Already says Major, normalize capitalization only
        $key = preg_replace('/major/i', 'Major', $key);
    } elseif (preg_match('/minor/i', $key)) {
        // Already says Minor, normalize capitalization only
        $key = preg_replace('/minor/i', 'Minor', $key);
    } elseif (preg_match('/maj/i', $key)) {
        // "maj" abbreviation → replace the whole abbreviation
        $key = preg_replace('/maj/i', 'Major', $key);
    } elseif (preg_match('/min/i', $key)) {
        // "min" abbreviation → replace the whole abbreviation
        $key = preg_replace('/min/i', 'Minor', $key);
    } elseif (preg_match('/^[A-G][#b]?$/', $key)) {
        // Bare note like "C" or "F#" → assume Major
        $key = $key . ' Major';
    }

    $key = trim($key);

    if (empty($artist)) $artist = 'Unknown Artist';
    if (empty($title))  $title  = $stemType;

    $filename = $artist . ' - ' . $title . ' ' . $stemType . ' [BPM ' . $bpm . ' ' . $key . '].mp3';
    $filename = trim(preg_replace('/\s+/', ' ', $filename));

    header('Content-Type: audio/mpeg');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($filePath));
    header('Cache-Control: private');
    header('Pragma: private');
    header('Expires: 0');

    readfile($filePath);
    exit;
}

    // Getems (duplicate route tha — same fix lagaya)
    public function getStems(Request $request)
    {
        return $this->index($request);
    }

public function bulkDownload(Request $request)
{
    $user     = Auth::user();
    $userTier = $user?->plan_tier ?? 'free';

    if (!$user || $userTier !== 'full') {
        return response()->json([
            'success' => false,
            'message' => 'Bulk download is only available for Full Package users.'
        ], 403);
    }

    $stems = Stem::where('is_visible', true)->get();

    if ($stems->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No stems available for download.'
        ], 404);
    }

    // Windows-safe temp dir
    $tempDir     = sys_get_temp_dir();
    $zipFileName = 'Son Got Samples - Full Library ' . date('Y-m-d') . '.zip';
    $zipPath     = $tempDir . DIRECTORY_SEPARATOR . $zipFileName;

    $zip    = new ZipArchive();
    $result = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    if ($result !== true) {
        return response()->json([
            'success' => false,
            'message' => 'Could not create ZIP file. Code: ' . $result
        ], 500);
    }

    $categoryFolders = [
        'Acapella'     => 'Acapella/',
        'Drums'        => 'Drums/',
        'Bass'         => 'Bass/',
        'Melody'       => 'Melody/',
        'Instrumental' => 'Instrumental/',
    ];

    $addedCount  = 0;
    $failedCount = 0;

    foreach ($stems as $stem) {
        $pathsToTry = [
            storage_path('app/public/' . ($stem->storage_path ?? '')),
            public_path('storage/' . ($stem->storage_path ?? '')),
            storage_path('app/public/stems/' . ($stem->file_path ?? '')),
            public_path('storage/stems/' . ($stem->file_path ?? '')),
        ];

        $filePath = null;
        foreach ($pathsToTry as $path) {
            if ($path && file_exists($path) && is_readable($path)) {
                $filePath = realpath($path);
                break;
            }
        }

        if (!$filePath) {
            $failedCount++;
            continue;
        }

        // ── FILENAME FORMAT ──
        $artist   = trim(preg_replace('/[^a-zA-Z0-9\s\-\.]/', '', $stem->artist ?? 'Unknown Artist'));
        $title    = trim(preg_replace('/[^a-zA-Z0-9\s\-\.]/', '', $stem->title  ?? 'Unknown'));
        $stemType = trim($stem->stem_type   ?? 'Track');
        $bpm      = $stem->bpm             ?? '0';
        $key      = trim($stem->musical_key ?? '');

        if (stripos($key, 'maj') !== false) {
            $key = str_ireplace('maj', 'Major', $key);
        } elseif (stripos($key, 'min') !== false) {
            $key = str_ireplace('min', 'Minor', $key);
        } elseif (preg_match('/^[A-G][#b]?$/', $key)) {
            $key = $key . ' Major';
        }
        $key = trim($key);

        if (empty($artist)) $artist = 'Unknown Artist';
        if (empty($title))  $title  = $stemType;

        $filename = $artist . ' - ' . $title . ' ' . $stemType . ' [BPM ' . $bpm . ' ' . $key . '].mp3';
        $filename = trim(preg_replace('/\s+/', ' ', $filename));

        // Category folder
        $folder = $categoryFolders[$stem->stem_type ?? ''] ?? 'Other/';

        $zip->addFile($filePath, $folder . $filename);
        $addedCount++;

        // Log download
        Download::create([
            'user_id'       => $user->id,
            'stem_id'       => $stem->id,
            'ip_address'    => $request->ip(),
            'ip_hash'       => md5($request->ip()),
            'downloaded_at' => now(),
        ]);
    }

    if ($addedCount === 0) {
        $zip->close();
        @unlink($zipPath);
        return response()->json([
            'success' => false,
            'message' => 'No valid files found. Failed: ' . $failedCount
        ], 404);
    }

    $zip->close();

    if (!file_exists($zipPath) || filesize($zipPath) === 0) {
        @unlink($zipPath);
        return response()->json([
            'success' => false,
            'message' => 'ZIP creation failed.'
        ], 500);
    }

    return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
}

}