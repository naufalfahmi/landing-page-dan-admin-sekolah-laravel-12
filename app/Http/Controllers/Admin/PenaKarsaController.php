<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenaKarsa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PenaKarsaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penaKarsa = PenaKarsa::latest()
            ->paginate(10);

        return view('admin.pena-karsa.index', compact('penaKarsa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pena-karsa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'excerpt' => 'required|string|max:500',
                'content' => 'required|string',
                'author_name' => 'required|string|max:255',
                'author_type' => 'required|in:student,teacher,guest',
                'author_class' => 'nullable|string|max:50',
                'author_position' => 'nullable|string|max:100',
                'type' => 'required|in:article,opinion,essay,motivation,creative',
                'status' => 'required|in:published,draft,archived',
                'is_featured' => 'boolean',
                'tags' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'published_at' => 'nullable|date'
            ]);

            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('pena-karsa', $imageName, 'public');
                $data['image'] = $imagePath;
                
                // Generate optimized og:image
                $this->generateOgImage($image, $imageName);
            }

            // Set published_at if status is published and no date provided
            if ($data['status'] === 'published' && empty($data['published_at'])) {
                $data['published_at'] = now();
            }

            // Convert tags string to array and then to JSON
            if (isset($data['tags'])) {
                if (is_string($data['tags'])) {
                    // Split by comma and trim each tag
                    $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));
                } elseif (is_array($data['tags'])) {
                    $data['tags'] = array_filter($data['tags']); // Remove empty tags
                }
            }

            PenaKarsa::create($data);

            return redirect()->route('admin.pena-karsa.index')
                ->with('success', 'Tulisan Pena Karsa berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PenaKarsa $penaKarsa)
    {
        return view('admin.pena-karsa.show', compact('penaKarsa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PenaKarsa $penaKarsa)
    {
        return view('admin.pena-karsa.edit', compact('penaKarsa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PenaKarsa $penaKarsa)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'excerpt' => 'required|string|max:500',
                'content' => 'required|string',
                'author_name' => 'required|string|max:255',
                'author_type' => 'required|in:student,teacher,guest',
                'author_class' => 'nullable|string|max:50',
                'author_position' => 'nullable|string|max:100',
                'type' => 'required|in:article,opinion,essay,motivation,creative',
                'status' => 'required|in:published,draft,archived',
                'is_featured' => 'boolean',
                'tags' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'published_at' => 'nullable|date'
            ]);

            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image and og:image if exists
                if ($penaKarsa->image && Storage::disk('public')->exists($penaKarsa->image)) {
                    Storage::disk('public')->delete($penaKarsa->image);
                    
                    // Also delete old og:image
                    $oldOgImagePath = 'pena-karsa/og-images/' . basename($penaKarsa->image);
                    if (Storage::disk('public')->exists($oldOgImagePath)) {
                        Storage::disk('public')->delete($oldOgImagePath);
                    }
                    if (file_exists(public_path('storage/' . $oldOgImagePath))) {
                        unlink(public_path('storage/' . $oldOgImagePath));
                    }
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('pena-karsa', $imageName, 'public');
                $data['image'] = $imagePath;
                
                // Generate optimized og:image
                $this->generateOgImage($image, $imageName);
            }

            // Set published_at if status is published and no date provided
            if ($data['status'] === 'published' && empty($data['published_at'])) {
                $data['published_at'] = now();
            }

            // Convert tags string to array and then to JSON
            if (isset($data['tags'])) {
                if (is_string($data['tags'])) {
                    // Split by comma and trim each tag
                    $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));
                } elseif (is_array($data['tags'])) {
                    $data['tags'] = array_filter($data['tags']); // Remove empty tags
                }
            }

            $penaKarsa->update($data);

            return redirect()->route('admin.pena-karsa.index')
                ->with('success', 'Tulisan Pena Karsa berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenaKarsa $penaKarsa)
    {
        try {
            // Delete image if exists
            if ($penaKarsa->image && Storage::disk('public')->exists($penaKarsa->image)) {
                Storage::disk('public')->delete($penaKarsa->image);
            }

            $penaKarsa->delete();

            return redirect()->route('admin.pena-karsa.index')
                ->with('success', 'Tulisan Pena Karsa berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Generate optimized og:image for social media sharing
     */
    private function generateOgImage($image, $imageName)
    {
        try {
            $manager = new ImageManager(new Driver());
            
            // Create og-images directory if it doesn't exist
            $ogImageDir = storage_path('app/public/pena-karsa/og-images');
            if (!file_exists($ogImageDir)) {
                mkdir($ogImageDir, 0755, true);
            }
            
            // Also create public og-images directory
            $publicOgImageDir = public_path('storage/pena-karsa/og-images');
            if (!file_exists($publicOgImageDir)) {
                mkdir($publicOgImageDir, 0755, true);
            }
            
            // Process image
            $img = $manager->read($image->getPathname());
            
            // Resize to og:image standard size (1200x630)
            $img->cover(1200, 630);
            
            // Save og:image to storage
            $ogImagePath = storage_path('app/public/pena-karsa/og-images/' . $imageName);
            $img->save($ogImagePath, 80); // 80% quality for smaller file size
            
            // Also save to public directory for immediate access
            $publicOgImagePath = public_path('storage/pena-karsa/og-images/' . $imageName);
            $img->save($publicOgImagePath, 80);
            
            \Log::info('OG Image generated successfully: ' . $ogImagePath);
            
        } catch (\Exception $e) {
            \Log::error('OG Image generation failed: ' . $e->getMessage());
        }
    }
}
