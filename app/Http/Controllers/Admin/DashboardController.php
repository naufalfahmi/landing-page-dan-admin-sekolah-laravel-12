<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use App\Models\User;
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

        $recent_articles = Article::with('author')
            ->latest()
            ->take(5)
            ->get();

        $recent_authors = Author::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_articles', 'recent_authors'));
    }
}
