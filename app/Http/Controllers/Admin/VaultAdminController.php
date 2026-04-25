<?php
// app/Http/Controllers/Admin/VaultAdminController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VaultGenreMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VaultAdminController extends Controller
{
    /**
     * GET /manage-panel-x9k/api/vault/genres
     * Fetch genres from external API, merge with DB meta
     */
    public function index()
    {
        // 1. Fetch live genres from external API
        $response = Http::timeout(10)->get('https://songotsamples.com/api/vault/genres');

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch genres from upstream API'], 502);
        }

        $apiData = $response->json();
        $genres  = $apiData['genres'] ?? [];

        // 2. Load all meta rows from DB keyed by genre_id
        $metaMap = VaultGenreMeta::all()->keyBy('genre_id');

        // 3. Merge: DB meta overrides static API desc/tags; add hidden flag
        $merged = collect($genres)->map(function ($genre) use ($metaMap) {
            $meta = $metaMap->get($genre['id']);
            return [
                'id'     => $genre['id'],
                'name'   => $genre['name'],
                'stems'  => $genre['stems'],
                'size'   => $genre['size'],
                'color'  => $genre['color'] ?? '#8097ff',
                'desc'   => $meta?->description ?? $genre['desc'] ?? '',
                'tags'   => $meta?->tags        ?? $genre['tags'] ?? [],
                'hidden' => $meta?->is_hidden   ?? false,
            ];
        })->values();

        return response()->json([
            'genres'      => $merged,
            'totalStems'  => $apiData['totalStems']  ?? 0,
            'totalGenres' => $apiData['totalGenres'] ?? 0,
            'totalSize'   => $apiData['totalSize']   ?? '—',
        ]);
    }

    public function meta()
{
    $map = VaultGenreMeta::all()->keyBy('genre_id')->map(fn($m) => [
        'description' => $m->description,
        'tags'        => $m->tags,
        'is_hidden'   => $m->is_hidden,
    ]);

    return response()->json(['meta' => $map]);
}

    /**
     * PATCH /manage-panel-x9k/api/vault/genres/{genreId}
     * Update desc, tags, or hidden for a genre
     */
    public function update(Request $request, string $genreId)
    {
        $validated = $request->validate([
            'description' => 'sometimes|nullable|string|max:240',
            'tags'        => 'sometimes|array',
            'tags.*'      => 'string|max:40',
            'is_hidden'   => 'sometimes|boolean',
        ]);

        $meta = VaultGenreMeta::updateOrCreate(
            ['genre_id' => $genreId],
            $validated
        );

        return response()->json(['success' => true, 'meta' => $meta]);
    }

    /**
     * PATCH /manage-panel-x9k/api/vault/genres/{genreId}/toggle
     * Quick toggle hidden status
     */
    public function toggleVisibility(string $genreId)
    {
        $meta = VaultGenreMeta::firstOrCreate(
            ['genre_id' => $genreId],
            ['is_hidden' => false]
        );

        $meta->is_hidden = !$meta->is_hidden;
        $meta->save();

        return response()->json([
            'success'   => true,
            'is_hidden' => $meta->is_hidden,
            'message'   => $meta->is_hidden ? 'Genre hidden' : 'Genre now visible',
        ]);
    }
}
