<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenaKarsa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                'tags' => 'nullable|array',
                'tags.*' => 'string|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'published_at' => 'nullable|date'
            ]);

            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('pena-karsa', 'public');
                $data['image'] = $imagePath;
            }

            // Set published_at if status is published and no date provided
            if ($data['status'] === 'published' && empty($data['published_at'])) {
                $data['published_at'] = now();
            }

            // Convert tags array to JSON
            if (isset($data['tags']) && is_array($data['tags'])) {
                $data['tags'] = array_filter($data['tags']); // Remove empty tags
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
                'tags' => 'nullable|array',
                'tags.*' => 'string|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'published_at' => 'nullable|date'
            ]);

            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($penaKarsa->image && Storage::disk('public')->exists($penaKarsa->image)) {
                    Storage::disk('public')->delete($penaKarsa->image);
                }
                
                $imagePath = $request->file('image')->store('pena-karsa', 'public');
                $data['image'] = $imagePath;
            }

            // Set published_at if status is published and no date provided
            if ($data['status'] === 'published' && empty($data['published_at'])) {
                $data['published_at'] = now();
            }

            // Convert tags array to JSON
            if (isset($data['tags']) && is_array($data['tags'])) {
                $data['tags'] = array_filter($data['tags']); // Remove empty tags
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
}
