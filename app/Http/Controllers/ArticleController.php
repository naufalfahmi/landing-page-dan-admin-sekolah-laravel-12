<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Models\Shortlink;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles
     */
    public function index()
    {
        $articles = Article::with(['author', 'categories'])
            ->published()
            ->latest('published_at')
            ->paginate(12);

        return view('articles.index', compact('articles'));
    }

    /**
     * Get articles from database
     */
    private function getArticlesData()
    {
        return Article::with('author')
            ->published()
            ->latest('published_at')
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'excerpt' => $article->excerpt,
                    'description' => $article->content,
                    'image' => $article->image,
                    'categories' => $article->categories,
                    'author' => $article->author->name,
                    'date' => $article->published_at->format('d/m/Y')
                ];
            });
    }

    /**
     * Menampilkan artikel berdasarkan slug
     */
    public function showBySlug($slug)
    {
        // Cari artikel berdasarkan slug
        $article = Article::with(['author', 'categories'])
            ->where('slug', $slug)
            ->published()
            ->first();
        
        if (!$article) {
            abort(404);
        }

        // Increment view count (prevent double counting in same session)
        $sessionKey = 'viewed_article_' . $article->id;
        if (!session()->has($sessionKey)) {
            $article->increment('views');
            session()->put($sessionKey, true);
        }

        // Ambil 5 artikel terbaru untuk sidebar (exclude artikel yang sedang dibaca)
        $recentPosts = Article::with(['author', 'categories'])
            ->published()
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        // Buat atau ambil shortlink untuk artikel ini
        $targetUrl = route('article.detail', $slug);
        $shortlink = Shortlink::createForArticle($article->id, $targetUrl);

        // Convert article to array format for view compatibility
        $articleData = [
            'id' => $article->id,
            'title' => $article->title,
            'excerpt' => $article->excerpt,
            'description' => $article->content,
            'image' => $article->image,
            'categories' => $article->categories,
            'author' => $article->author->name,
            'date' => $article->published_at->format('d/m/Y'),
            'views' => $article->views,
            'shortlink' => $shortlink->full_url
        ];

        // Convert recent posts to array format
        $recentPostsData = $recentPosts->map(function($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'excerpt' => $post->excerpt,
                'description' => $post->content,
                'image' => $post->image,
                'categories' => $post->categories,
                'author' => $post->author->name,
                'date' => $post->published_at->format('d/m/Y')
            ];
        });

        return view('article-detail', [
            'article' => $articleData,
            'recentPosts' => $recentPostsData,
            'allArticles' => collect() // For backward compatibility
        ]);
    }

    /**
     * Menampilkan artikel berdasarkan kategori
     */
    public function showByCategory($slug)
    {
        // Cari kategori berdasarkan slug
        $category = \App\Models\Category::where('slug', $slug)->first();
        
        if (!$category) {
            abort(404, 'Kategori tidak ditemukan');
        }

        // Ambil artikel yang memiliki kategori tersebut
        $articles = Article::with(['author', 'categories'])
            ->whereHas('categories', function($query) use ($category) {
                $query->where('categories.id', $category->id);
            })
            ->published()
            ->latest('published_at')
            ->paginate(6);

        return view('category', [
            'articles' => $articles,
            'categoryName' => $category->name
        ]);
    }

    /**
     * Menampilkan artikel berdasarkan author
     */
    public function showByAuthor($slug)
    {
        // Implementasi untuk menampilkan artikel berdasarkan author
        return view('author', compact('slug'));
    }

    /**
     * Method lama untuk backward compatibility
     */
    public function show($id)
    {
        return $this->showBySlug($id);
    }
}