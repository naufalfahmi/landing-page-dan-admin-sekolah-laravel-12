<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use App\Models\User;
use App\Models\PageView;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'total_authors' => Author::count(),
            'total_users' => User::count(),
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

        $recent_authors = Author::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'recent_articles', 
            'recent_authors',
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
