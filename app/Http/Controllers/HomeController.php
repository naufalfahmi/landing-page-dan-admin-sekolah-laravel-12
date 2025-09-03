<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

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
            ->paginate(12);

        return view('home', compact('articles'));
    }
}
