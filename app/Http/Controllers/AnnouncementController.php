<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementCategory;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements.
     */
    public function index(Request $request)
    {
        $query = Announcement::with('category')->published()->latest('published_at');

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority) {
            $query->byPriority($request->priority);
        }

        $announcements = $query->paginate(10)->withQueryString();

        // Get active categories for filter
        $categories = AnnouncementCategory::active()->ordered()->get();

        $priorities = [
            'urgent' => 'Mendesak',
            'high' => 'Tinggi',
            'normal' => 'Normal',
            'low' => 'Rendah'
        ];

        return view('announcements.index', compact('announcements', 'categories', 'priorities'));
    }

    /**
     * Display the specified announcement.
     */
    public function show(Announcement $announcement)
    {
        // Load category relationship
        $announcement->load('category');
        
        // Increment view count
        $announcement->incrementViews();

        // Get related announcements from same category
        $relatedAnnouncements = Announcement::with('category')
            ->published()
            ->where('id', '!=', $announcement->id)
            ->where('category_id', $announcement->category_id)
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('announcements.show', compact('announcement', 'relatedAnnouncements'));
    }

    /**
     * Get featured announcements for homepage widget
     */
    public function getFeatured()
    {
        return Announcement::with('category')
            ->published()
            ->featured()
            ->latest('published_at')
            ->take(5)
            ->get();
    }

    /**
     * Get latest announcements for homepage widget
     */
    public function getLatest()
    {
        return Announcement::with('category')
            ->published()
            ->latest('published_at')
            ->take(5)
            ->get();
    }
}