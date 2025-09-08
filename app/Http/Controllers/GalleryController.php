<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of galleries.
     */
    public function index(Request $request)
    {
        $query = Gallery::with('category')->published()->ordered();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        $galleries = $query->paginate(12);

        // Get active categories for filter
        $categories = GalleryCategory::active()->ordered()->get();

        return view('galleries.index', compact('galleries', 'categories'));
    }

    /**
     * Display the specified gallery.
     */
    public function show(Gallery $gallery)
    {
        // Load category relationship
        $gallery->load('category');
        
        // Increment view count
        $gallery->incrementViews();

        // Previous and next within the same category, following the same ordering logic
        $previousGallery = Gallery::published()
            ->where('category_id', $gallery->category_id)
            ->where(function ($q) use ($gallery) {
                $q->where('sort_order', '<', $gallery->sort_order)
                  ->orWhere(function ($q2) use ($gallery) {
                      $q2->where('sort_order', $gallery->sort_order)
                         ->where('created_at', '>', $gallery->created_at);
                  });
            })
            ->orderBy('sort_order', 'desc')
            ->orderBy('created_at', 'asc')
            ->first();

        $nextGallery = Gallery::published()
            ->where('category_id', $gallery->category_id)
            ->where(function ($q) use ($gallery) {
                $q->where('sort_order', '>', $gallery->sort_order)
                  ->orWhere(function ($q2) use ($gallery) {
                      $q2->where('sort_order', $gallery->sort_order)
                         ->where('created_at', '<', $gallery->created_at);
                  });
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->first();

        // Get related galleries from same category
        $relatedGalleries = Gallery::with('category')
            ->published()
            ->where('id', '!=', $gallery->id)
            ->where('category_id', $gallery->category_id)
            ->ordered()
            ->take(6)
            ->get();

        return view('galleries.show', compact('gallery', 'relatedGalleries', 'previousGallery', 'nextGallery'));
    }

    /**
     * Get featured galleries for homepage widget
     */
    public function getFeatured()
    {
        return Gallery::with('category')
            ->published()
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
        return Gallery::with('category')
            ->published()
            ->ordered()
            ->take(8)
            ->get();
    }
}