<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Announcement;

class HomeController extends Controller
{
    /**
     * Display the home page with articles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $articles = Article::with(['author', 'categories'])
            ->published()
            ->latest('published_at')
            ->take(6)
            ->get();

        $announcements = Announcement::published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('home', compact('articles', 'announcements'));
    }
}
