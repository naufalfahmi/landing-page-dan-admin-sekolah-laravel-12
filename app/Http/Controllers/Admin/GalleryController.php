<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::with('category')->latest()->paginate(10);
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = GalleryCategory::active()->ordered()->get();
        return view('admin.galleries.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            'category_id' => 'required|exists:gallery_categories,id',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $baseData = [
            'description' => $request->description,
            'category_id' => $request->category_id,
            'is_published' => $request->has('is_published'),
            'is_featured' => $request->has('is_featured'),
            'sort_order' => $request->sort_order ?? 0,
        ];

        $uploadedCount = 0;
        $errors = [];

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $baseTitle = $request->title;
            
            foreach ($images as $index => $image) {
                try {
                    // Generate title with numbering if multiple images
                    $title = count($images) > 1 ? $baseTitle . ' #' . ($index + 1) : $baseTitle;
                    
                    $imageName = time() . '_' . Str::slug($title) . '_' . ($index + 1) . '.' . $image->getClientOriginalExtension();
                    $imagePath = $image->storeAs('galleries', $imageName, 'public');

                    // Auto-generate thumbnail
                    $this->generateThumbnail($image, $imageName);

                    // Create gallery record
                    Gallery::create(array_merge($baseData, [
                        'title' => $title,
                        'image' => $imagePath,
                        'thumbnail' => 'galleries/thumbnails/' . $imageName,
                    ]));

                    $uploadedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Gambar " . ($index + 1) . ": " . $e->getMessage();
                }
            }
        }

        if ($uploadedCount > 0) {
            $message = $uploadedCount . ' foto berhasil ditambahkan ke galeri.';
            if (!empty($errors)) {
                $message .= ' Beberapa gambar gagal diupload: ' . implode(', ', $errors);
            }
            return redirect()->route('admin.galleries.index')
                ->with('success', $message);
        } else {
            return redirect()->back()
                ->withErrors(['images' => 'Tidak ada gambar yang berhasil diupload.'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        $gallery->load('category');
        return view('admin.galleries.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        $categories = GalleryCategory::active()->ordered()->get();
        return view('admin.galleries.edit', compact('gallery', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            'category_id' => 'required|exists:gallery_categories,id',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $baseData = [
            'description' => $request->description,
            'category_id' => $request->category_id,
            'is_published' => $request->has('is_published'),
            'is_featured' => $request->has('is_featured'),
            'sort_order' => $request->sort_order ?? 0,
        ];

        $uploadedCount = 0;
        $errors = [];

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            \Log::info('Multiple images upload detected in edit gallery');
            
            // Delete old image and thumbnail
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
                \Log::info('Old image deleted: ' . $gallery->image);
            }
            if ($gallery->thumbnail && Storage::disk('public')->exists($gallery->thumbnail)) {
                Storage::disk('public')->delete($gallery->thumbnail);
                \Log::info('Old thumbnail deleted: ' . $gallery->thumbnail);
            }
            
            $images = $request->file('images');
            $baseTitle = $request->title;
            
            foreach ($images as $index => $image) {
                try {
                    // Generate title with numbering if multiple images
                    $title = count($images) > 1 ? $baseTitle . ' #' . ($index + 1) : $baseTitle;
                    
                    $imageName = time() . '_' . Str::slug($title) . '_' . ($index + 1) . '.' . $image->getClientOriginalExtension();
                    $imagePath = $image->storeAs('galleries', $imageName, 'public');

                    // Auto-generate thumbnail
                    \Log::info('Starting thumbnail generation for: ' . $imageName);
                    $this->generateThumbnail($image, $imageName);

                    // Create gallery record
                    Gallery::create(array_merge($baseData, [
                        'title' => $title,
                        'image' => $imagePath,
                        'thumbnail' => 'galleries/thumbnails/' . $imageName,
                    ]));

                    $uploadedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Gambar " . ($index + 1) . ": " . $e->getMessage();
                }
            }
        } else {
            // No new images, just update the existing gallery
            $gallery->update(array_merge($baseData, [
                'title' => $request->title,
            ]));
        }

        if ($uploadedCount > 0) {
            $message = $uploadedCount . ' foto berhasil ditambahkan ke galeri.';
            if (!empty($errors)) {
                $message .= ' Beberapa gambar gagal diupload: ' . implode(', ', $errors);
            }
        } else {
            $message = 'Galeri berhasil diperbarui.';
        }

        return redirect()->route('admin.galleries.index')
            ->with('success', $message);
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

    /**
     * Generate thumbnail from uploaded image
     */
    private function generateThumbnail($image, $imageName)
    {
        try {
            $manager = new ImageManager(new Driver());
            
            // Create thumbnail directory if it doesn't exist
            $thumbnailDir = storage_path('app/public/galleries/thumbnails');
            if (!file_exists($thumbnailDir)) {
                mkdir($thumbnailDir, 0755, true);
            }
            
            // Also create public thumbnail directory
            $publicThumbnailDir = public_path('storage/galleries/thumbnails');
            if (!file_exists($publicThumbnailDir)) {
                mkdir($publicThumbnailDir, 0755, true);
            }
            
            // Process image
            $img = $manager->read($image->getPathname());
            
            // Resize to thumbnail size (300x300, maintain aspect ratio)
            $img->cover(300, 300);
            
            // Save thumbnail to storage
            $thumbnailPath = storage_path('app/public/galleries/thumbnails/' . $imageName);
            $img->save($thumbnailPath, 85); // 85% quality
            
            // Also save to public directory for immediate access
            $publicThumbnailPath = public_path('storage/galleries/thumbnails/' . $imageName);
            $img->save($publicThumbnailPath, 85);
            
            // Log success for debugging
            \Log::info('Thumbnail generated successfully: ' . $thumbnailPath);
            \Log::info('Public thumbnail saved: ' . $publicThumbnailPath);
            
        } catch (\Exception $e) {
            // Log error but don't fail the upload
            \Log::error('Thumbnail generation failed: ' . $e->getMessage());
            \Log::error('Image path: ' . $image->getPathname());
            \Log::error('Image name: ' . $imageName);
        }
    }
}
