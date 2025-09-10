<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class GalleryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = GalleryCategory::withCount('galleries')
            ->latest()
            ->paginate(10);

        return view('admin.gallery-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:gallery_categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'color' => 'required|in:primary,secondary,success,danger,warning,info,light,dark',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $galleryCategory = GalleryCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'color' => $request->color,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori galeri berhasil dibuat.',
                'category' => $galleryCategory
            ]);
        }

        return redirect()->route('admin.gallery-categories.index')
            ->with('success', 'Kategori galeri berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GalleryCategory $galleryCategory)
    {
        $galleryCategory->load(['galleries' => function($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.gallery-categories.show', compact('galleryCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GalleryCategory $galleryCategory)
    {
        return view('admin.gallery-categories.edit', compact('galleryCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GalleryCategory $galleryCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:gallery_categories,name,' . $galleryCategory->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'color' => 'required|in:primary,secondary,success,danger,warning,info,light,dark',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $galleryCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'color' => $request->color,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.gallery-categories.index')
            ->with('success', 'Kategori galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GalleryCategory $galleryCategory)
    {
        // Check if category has galleries
        if ($galleryCategory->galleries()->count() > 0) {
            return redirect()->route('admin.gallery-categories.index')
                ->with('error', 'Tidak dapat menghapus kategori yang memiliki galeri.');
        }

        $galleryCategory->delete();

        return redirect()->route('admin.gallery-categories.index')
            ->with('success', 'Kategori galeri berhasil dihapus.');
    }
}
