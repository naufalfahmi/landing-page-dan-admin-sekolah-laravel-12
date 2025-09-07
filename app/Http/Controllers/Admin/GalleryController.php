<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::ordered()->paginate(10);
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|in:kegiatan-belajar,ekstrakurikuler,acara-sekolah,fasilitas',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('galleries', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_thumb_' . Str::slug($request->title) . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnailPath = $thumbnail->storeAs('galleries/thumbnails', $thumbnailName, 'public');
            $data['thumbnail'] = $thumbnailPath;
        }

        $data['is_published'] = $request->has('is_published');
        $data['is_featured'] = $request->has('is_featured');
        $data['sort_order'] = $request->sort_order ?? 0;

        Gallery::create($data);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return view('admin.galleries.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|in:kegiatan-belajar,ekstrakurikuler,acara-sekolah,fasilitas',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('galleries', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($gallery->thumbnail && Storage::disk('public')->exists($gallery->thumbnail)) {
                Storage::disk('public')->delete($gallery->thumbnail);
            }
            
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_thumb_' . Str::slug($request->title) . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnailPath = $thumbnail->storeAs('galleries/thumbnails', $thumbnailName, 'public');
            $data['thumbnail'] = $thumbnailPath;
        }

        $data['is_published'] = $request->has('is_published');
        $data['is_featured'] = $request->has('is_featured');
        $data['sort_order'] = $request->sort_order ?? 0;

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        // Delete image files
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }
        if ($gallery->thumbnail && Storage::disk('public')->exists($gallery->thumbnail)) {
            Storage::disk('public')->delete($gallery->thumbnail);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }
}
