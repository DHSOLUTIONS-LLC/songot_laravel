<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stem;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DownloadApiController extends Controller
{
    private const GUEST_LIMIT = 5; // Guest max downloads per session

    public function download(Request $request, Stem $stem)
    {
        // Stem visible hai?
        if (!$stem->is_visible) {
            return response()->json(['success' => false, 'message' => 'Not found.'], 404);
        }

        $user = Auth::user();

        // ── Access check ──
        if (!$stem->isAccessibleBy($user)) {
            return response()->json([
                'success'         => false,
                'message'         => 'This stem requires a paid plan.',
                'require_upgrade' => true,
            ], 403);
        }

        // ── Guest download limit ──
        if (!$user) {
            $guestId = $request->session()->get('guest_session_id');
            if (!$guestId) {
                $guestId = Str::uuid()->toString();
                $request->session()->put('guest_session_id', $guestId);
            }

            $guestCount = $request->session()->get('guest_downloads', 0);

            if ($guestCount >= self::GUEST_LIMIT) {
                return response()->json([
                    'success'       => false,
                    'message'       => "You've reached your {self::GUEST_LIMIT} free downloads.",
                    'show_register' => true,
                ], 403);
            }

            // Increment
            $request->session()->put('guest_downloads', $guestCount + 1);
        }

        // ── Log the download ──
        Download::create([
            'user_id'          => $user?->id,
            'guest_session_id' => $user ? null : $request->session()->get('guest_session_id'),
            'stem_id'          => $stem->id,
            'ip_hash'          => md5($request->ip()),
            'user_agent'       => $request->userAgent(),
            'downloaded_at'    => now(),
            'source_type'      => $this->getSourceType($user),
            'status'           => 'success',
        ]);

        // ── Generate secure download URL ──
        $url = Storage::temporaryUrl(
            $stem->storage_path,
            now()->addMinutes(5) // 5 minute valid
        );

        return response()->json([
            'success'      => true,
            'download_url' => $url,
            'filename'     => $this->buildFilename($stem),
        ]);
    }

    private function getSourceType($user): string
    {
        if (!$user) return 'free';
        if (in_array($user->plan_tier, ['web_access', 'full_library'])) return 'paid';
        return 'free';
    }

    private function buildFilename(Stem $stem): string
    {
        $parts = array_filter([
            $stem->artist,
            $stem->title,
            $stem->bpm ? $stem->bpm . 'bpm' : null,
            $stem->musical_key,
        ]);
        $name = implode(' - ', $parts);
        // Special characters remove karo
        $name = preg_replace('/[^a-zA-Z0-9\s\-_]/', '', $name);
        return trim($name) . '.mp3';
    }
}