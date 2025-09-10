<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnnouncementCategory;
use Illuminate\Http\Request;

class AnnouncementCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = AnnouncementCategory::withCount('announcements')
            ->latest()
            ->paginate(10);

        return view('admin.announcement-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.announcement-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:announcement_categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'color' => 'required|in:primary,secondary,success,danger,warning,info,light,dark',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        AnnouncementCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'color' => $request->color,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.announcement-categories.index')
            ->with('success', 'Kategori pengumuman berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnnouncementCategory $announcementCategory)
    {
        $announcementCategory->load(['announcements' => function($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.announcement-categories.show', compact('announcementCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnnouncementCategory $announcementCategory)
    {
        return view('admin.announcement-categories.edit', compact('announcementCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnnouncementCategory $announcementCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:announcement_categories,name,' . $announcementCategory->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'color' => 'required|in:primary,secondary,success,danger,warning,info,light,dark',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $announcementCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'color' => $request->color,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.announcement-categories.index')
            ->with('success', 'Kategori pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnnouncementCategory $announcementCategory)
    {
        // Check if category has announcements
        if ($announcementCategory->announcements()->count() > 0) {
            return redirect()->route('admin.announcement-categories.index')
                ->with('error', 'Tidak dapat menghapus kategori yang memiliki pengumuman.');
        }

        $announcementCategory->delete();

        return redirect()->route('admin.announcement-categories.index')
            ->with('success', 'Kategori pengumuman berhasil dihapus.');
    }
}
