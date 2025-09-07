<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements.
     */
    public function index(Request $request)
    {
        $query = Announcement::published()->latest('published_at');

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority) {
            $query->byPriority($request->priority);
        }

        $announcements = $query->paginate(10);

        $categories = [
            'akademik' => 'Akademik',
            'kegiatan' => 'Kegiatan',
            'ujian' => 'Ujian',
            'libur' => 'Libur',
            'umum' => 'Umum'
        ];

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
        // Increment view count
        $announcement->incrementViews();

        // Get related announcements
        $relatedAnnouncements = Announcement::published()
            ->where('id', '!=', $announcement->id)
            ->where('category', $announcement->category)
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
        return Announcement::published()
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
        return Announcement::published()
            ->latest('published_at')
            ->take(5)
            ->get();
    }
}