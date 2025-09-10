<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use App\Models\User;
use App\Models\PageView;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\PenaKarsa;
use App\Models\Slider;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            // Articles
            'total_articles' => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'draft_articles' => Article::where('status', 'draft')->count(),
            
            // Authors & Users
            'total_authors' => Author::count(),
            'active_authors' => Author::where('is_active', true)->count(),
            'total_users' => User::count(),
            
            // Announcements
            'total_announcements' => Announcement::count(),
            'published_announcements' => Announcement::where('is_published', true)->count(),
            'draft_announcements' => Announcement::where('is_published', false)->count(),
            
            // Galleries
            'total_galleries' => Gallery::count(),
            'published_galleries' => Gallery::where('is_published', true)->count(),
            'featured_galleries' => Gallery::where('is_featured', true)->count(),
            
            // Pena Karsa
            'total_pena_karsa' => PenaKarsa::count(),
            'published_pena_karsa' => PenaKarsa::where('status', 'published')->count(),
            'featured_pena_karsa' => PenaKarsa::where('is_featured', true)->count(),
            
            // Sliders
            'total_sliders' => Slider::count(),
            'active_sliders' => Slider::where('is_active', true)->count(),
            
            // Contact Messages
            'total_contact_messages' => ContactMessage::count(),
            'unread_contact_messages' => ContactMessage::where('status', 'unread')->count(),
            'replied_contact_messages' => ContactMessage::where('status', 'replied')->count(),
        ];

        // Page views statistics
        $pageViewsStats = [
            'today' => PageView::getStats('today'),
            'week' => PageView::getStats('week'),
            'month' => PageView::getStats('month'),
            'year' => PageView::getStats('year'),
        ];

        // Daily page views for chart (last 30 days)
        $dailyViews = PageView::getDailyViews(30);

        $recent_articles = Article::with('author')
            ->latest()
            ->take(5)
            ->get();

        $recent_authors = Author::withCount('articles')
            ->latest()
            ->take(5)
            ->get();

        // Recent activities
        $recent_announcements = Announcement::with('category')
            ->latest()
            ->take(3)
            ->get();

        $recent_galleries = Gallery::with('category')
            ->latest()
            ->take(3)
            ->get();

        $recent_pena_karsa = PenaKarsa::latest()
            ->take(3)
            ->get();

        // Alerts & Notifications
        $alerts = [
            'unread_messages' => ContactMessage::where('status', 'unread')->count(),
            'draft_articles' => Article::where('status', 'draft')->count(),
            'draft_announcements' => Announcement::where('is_published', false)->count(),
        ];

        return view('admin.dashboard', compact(
            'stats', 
            'recent_articles', 
            'recent_authors',
            'recent_announcements',
            'recent_galleries',
            'recent_pena_karsa',
            'alerts',
            'pageViewsStats',
            'dailyViews'
        ));
    }

    /**
     * Get top pages statistics via AJAX
     */
    public function getTopPages(Request $request)
    {
        $period = $request->get('period', 'month');
        $limit = $request->get('limit', 10);
        
        $stats = PageView::getStats($period);
        $topPages = $stats['top_pages']->take($limit);
        
        return response()->json([
            'success' => true,
            'data' => $topPages,
            'period' => $period,
            'total' => $stats['total_views']
        ]);
    }
}
