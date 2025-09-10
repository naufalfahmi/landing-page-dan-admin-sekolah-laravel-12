<?php

namespace App\Http\Controllers;

use App\Models\PenaKarsa;
use Illuminate\Http\Request;

class PenaKarsaController extends Controller
{
    /**
     * Display a listing of Pena Karsa articles.
     */
    public function index(Request $request)
    {
        $query = PenaKarsa::published()->latest('published_at');

        // Optional filter by type (article, opinion, essay, motivation, creative)
        if ($request->filled('type')) {
            $allowed = ['article', 'opinion', 'essay', 'motivation', 'creative'];
            $type = strtolower($request->get('type'));
            if (in_array($type, $allowed, true)) {
                $query->where('type', $type);
            }
        }

        $penaKarsa = $query->paginate(12)->withQueryString();

        return view('pena-karsa.index', compact('penaKarsa'));
    }

    /**
     * Display the specified Pena Karsa article.
     */
    public function show($slug)
    {
        $penaKarsa = PenaKarsa::where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment view count
        $penaKarsa->incrementViews();

        // Get related articles
        $relatedArticles = PenaKarsa::published()
            ->where('id', '!=', $penaKarsa->id)
            ->where('type', $penaKarsa->type)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pena-karsa.show', compact('penaKarsa', 'relatedArticles'));
    }
}