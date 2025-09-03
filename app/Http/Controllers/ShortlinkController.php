<?php

namespace App\Http\Controllers;

use App\Models\Shortlink;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ShortlinkController extends Controller
{
    /**
     * Admin: list shortlinks
     */
    public function index()
    {
        $shortlinks = Shortlink::orderByDesc('created_at')->get();
        return view('admin.shortlinks.index', compact('shortlinks'));
    }

    /**
     * Admin: store a new shortlink
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'original_url' => ['required', 'url'],
            'short_code' => ['nullable', 'alpha_dash', 'max:64', 'unique:shortlinks,short_code'],
        ]);

        $shortCode = $validated['short_code'] ?? Shortlink::generateShortCode();

        Shortlink::create([
            'short_code' => $shortCode,
            'target_url' => $validated['original_url'],
            'clicks' => 0,
        ]);

        return redirect()->route('admin.shortlinks.index')->with('success', 'Shortlink berhasil dibuat');
    }

    /**
     * Admin: delete a shortlink
     */
    public function destroy(string $id): RedirectResponse
    {
        $shortlink = Shortlink::findOrFail($id);
        $shortlink->delete();
        return redirect()->route('admin.shortlinks.index')->with('success', 'Shortlink berhasil dihapus');
    }

    /**
     * Redirect shortlink ke URL target
     *
     * @param string $shortCode
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect(string $shortCode): RedirectResponse
    {
        // Cari shortlink berdasarkan short code
        $shortlink = Shortlink::where('short_code', $shortCode)->first();
        
        if (!$shortlink) {
            // Jika shortlink tidak ditemukan, redirect ke home
            return redirect('/')->with('error', 'Shortlink tidak ditemukan');
        }
        
        // Cek apakah shortlink expired
        if ($shortlink->isExpired()) {
            return redirect('/')->with('error', 'Shortlink sudah expired');
        }
        
        // Increment click count
        $shortlink->incrementClicks();
        
        // Redirect ke URL target
        return redirect($shortlink->target_url);
    }
    
    /**
     * Create shortlink untuk artikel (untuk testing)
     *
     * @param int $articleId
     * @return \Illuminate\Http\JsonResponse
     */
    public function createForArticle(int $articleId)
    {
        $targetUrl = route('article.detail', $articleId);
        $shortlink = Shortlink::createForArticle($articleId, $targetUrl);
        
        return response()->json([
            'success' => true,
            'shortlink' => $shortlink->full_url,
            'short_code' => $shortlink->short_code,
            'target_url' => $shortlink->target_url
        ]);
    }
    
    /**
     * Get shortlink info (untuk testing)
     *
     * @param string $shortCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(string $shortCode)
    {
        $shortlink = Shortlink::where('short_code', $shortCode)->first();
        
        if (!$shortlink) {
            return response()->json([
                'success' => false,
                'message' => 'Shortlink tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'shortlink' => $shortlink->full_url,
            'short_code' => $shortlink->short_code,
            'target_url' => $shortlink->target_url,
            'clicks' => $shortlink->clicks,
            'created_at' => $shortlink->created_at,
            'expires_at' => $shortlink->expires_at
        ]);
    }
}
