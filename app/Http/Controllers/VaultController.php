<?php

namespace App\Http\Controllers;

use App\Models\Stem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str;
use App\Models\VaultGenreMeta;


class VaultController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user || $user->plan_tier !== 'full') {
            abort(403, 'This page is only available for Full Package users.');
        }
        
        $genres = [
            'Acapella' => Stem::where('is_visible', true)->where('stem_type', 'Acapella')->count(),
            'Drums' => Stem::where('is_visible', true)->where('stem_type', 'Drums')->count(),
            'Bass' => Stem::where('is_visible', true)->where('stem_type', 'Bass')->count(),
            'Melody' => Stem::where('is_visible', true)->where('stem_type', 'Melody')->count(),
            'Instrumental' => Stem::where('is_visible', true)->where('stem_type', 'Instrumental')->count(),
        ];
        
        return view('pages.vault', compact('genres'));
    }
               public function downloadByGenre($genre)
{
    $user = Auth::user();

    if (!$user || $user->plan_tier !== 'full') {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $exists = Stem::where('is_visible', true)
        ->where('genre', $genre)
        ->exists();

    if (!$exists) {
        return response()->json(['error' => 'Invalid genre'], 400);
    }

    $stems = Stem::where('is_visible', true)
        ->where('genre', $genre)
        ->get();

    $tempDir     = sys_get_temp_dir();
    $zipFileName = $genre . ' Library ' . date('Y-m-d') . '.zip';
    $zipPath     = $tempDir . DIRECTORY_SEPARATOR . $zipFileName;

    $zip    = new ZipArchive();
    $result = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    if ($result !== true) {
        return response()->json([
            'error' => 'Could not create ZIP. Code: ' . $result,
            'path'  => $zipPath
        ], 500);
    }

    $addedCount = 0;

    foreach ($stems as $stem) {
        $pathsToTry = [
            storage_path('app/public/' . ($stem->storage_path ?? '')),
            public_path('storage/' . ($stem->storage_path ?? '')),
        ];

        $filePath = null;
        foreach ($pathsToTry as $path) {
            if ($path && file_exists($path) && is_readable($path)) {
                $filePath = realpath($path);
                break;
            }
        }

        if (!$filePath) continue;

        // ── FILENAME FORMAT ──
        $artist   = trim(preg_replace('/[^a-zA-Z0-9\s\-\.]/', '', $stem->artist ?? 'Unknown Artist'));
        $title    = trim(preg_replace('/[^a-zA-Z0-9\s\-\.]/', '', $stem->title  ?? 'Unknown'));
        $stemType = trim($stem->stem_type   ?? 'Track');
        $bpm      = $stem->bpm             ?? '0';
        $key = $this->normalizeMusicalKey($stem->musical_key ?? '');
        $key = trim($key);

        if (empty($artist)) $artist = 'Unknown Artist';
        if (empty($title))  $title  = $stemType;

        $filename = $artist . ' - ' . $title . ' ' . $stemType . ' [BPM ' . $bpm . ' ' . $key . '].mp3';
        $filename = trim(preg_replace('/\s+/', ' ', $filename));

        $zip->addFile($filePath, $genre . '/' . $filename);
        $addedCount++;
    }

    if ($addedCount === 0) {
        $zip->close();
        @unlink($zipPath);
        return response()->json(['error' => 'No valid files found.'], 404);
    }

    $zip->close();

    if (!file_exists($zipPath) || filesize($zipPath) === 0) {
        @unlink($zipPath);
        return response()->json(['error' => 'ZIP creation failed.'], 500);
    }

    return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
}

private function normalizeMusicalKey(string $key): string
{
    $key = trim($key);

    if (preg_match('/major/i', $key)) {
        return preg_replace('/major/i', 'Major', $key);
    } elseif (preg_match('/minor/i', $key)) {
        return preg_replace('/minor/i', 'Minor', $key);
    } elseif (preg_match('/maj/i', $key)) {
        return preg_replace('/maj/i', 'Major', $key);
    } elseif (preg_match('/min/i', $key)) {
        return preg_replace('/min/i', 'Minor', $key);
    } elseif (preg_match('/^[A-G][#b]?$/', $key)) {
        return $key . ' Major';
    }

    return $key;
}


public function getGenreStats()
{
    // Get all stems counts by genre
$genreCounts = Stem::where('is_visible', true)
    ->whereNotNull('genre')
    ->where('genre', '!=', '')
    ->select('genre', \DB::raw('count(*) as total'))
    ->groupBy('genre')
    ->orderBy('total', 'desc')
    ->get()
    ->toArray();
    
    $totalStemsnew  = Stem::where('is_visible', true)->count(); // ← keep this


$totalStems = Stem::where('is_visible', true)->count();
    $totalSizeMB = 0;
    
    $result = [];
    
    foreach ($genreCounts as $item) {
        $genreName = $item['genre'];
        $stemCount = $item['total'];
        $totalStems += $stemCount;
        
        // Calculate size (assuming ~15MB per stem)
        $sizeMB = $stemCount * 15;
        $totalSizeMB += $sizeMB;
        
        $size = $sizeMB < 1024 ? round($sizeMB) . ' MB' : round($sizeMB / 1024, 1) . ' GB';

        $id = strtolower(str_replace(' ', '-', $genreName));
        
        $result[] = [
            'id' => $id,
            'name' => $genreName,
            'stems' => $stemCount,
            'size' => $size,
            'tags' => ['Popular'],
            'desc' => $genreName . ' stems collection. High-quality samples for music production.',
            'color' => '#8097ff'
        ];
    }
    
    // Calculate total library size
    $totalSize = $totalSizeMB < 1024 
        ? round($totalSizeMB) . ' MB' 
        : round($totalSizeMB / 1024, 1) . ' GB';
    
    return response()->json([
        'genres' => $result,
        'totalStems' => $totalStemsnew,
        'totalGenres' => count($result),
        'totalSize' => $totalSize  // 👈 YEH ADD KARO
    ]);
}

}