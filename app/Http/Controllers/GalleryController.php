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

        // Get related galleries from same category
        $relatedGalleries = Gallery::with('category')
            ->published()
            ->where('id', '!=', $gallery->id)
            ->where('category_id', $gallery->category_id)
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