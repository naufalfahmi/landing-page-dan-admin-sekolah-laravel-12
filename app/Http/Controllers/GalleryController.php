<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of galleries.
     */
    public function index(Request $request)
    {
        $query = Gallery::published()->ordered();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        $galleries = $query->paginate(12);

        $categories = [
            'kegiatan-belajar' => 'Kegiatan Belajar',
            'ekstrakurikuler' => 'Ekstrakurikuler',
            'acara-sekolah' => 'Acara Sekolah',
            'fasilitas' => 'Fasilitas'
        ];

        return view('galleries.index', compact('galleries', 'categories'));
    }

    /**
     * Display the specified gallery.
     */
    public function show(Gallery $gallery)
    {
        // Increment view count
        $gallery->incrementViews();

        // Get related galleries
        $relatedGalleries = Gallery::published()
            ->where('id', '!=', $gallery->id)
            ->where('category', $gallery->category)
            ->ordered()
            ->take(6)
            ->get();

        return view('galleries.show', compact('gallery', 'relatedGalleries'));
    }

    /**
     * Get featured galleries for homepage widget
     */
    public function getFeatured()
    {
        return Gallery::published()
            ->featured()
            ->ordered()
            ->take(8)
            ->get();
    }

    /**
     * Get latest galleries for homepage widget
     */
    public function getLatest()
    {
        return Gallery::published()
            ->ordered()
            ->take(8)
            ->get();
    }
}