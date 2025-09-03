<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Shortlink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('author')
            ->latest()
            ->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::active()->get();
        $categories = Category::active()->get();

        return view('admin.articles.create', compact('authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'author_id' => 'required|exists:authors,id',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'short_code' => 'nullable|alpha_dash|max:64|unique:shortlinks,short_code',
        ]);

        $article = Article::create([
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'author_id' => $request->author_id,
            'image' => null,
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/articles', 'public');
            $article->image = asset('storage/' . $path);
            $article->save();
        }

        // Attach categories to article
        $article->categories()->attach($request->categories);

        // Create shortlink (customizable)
        $targetUrl = route('article.detail', $article->slug);
        $customCode = $request->input('short_code');
        $shortCode = $customCode ?: Shortlink::generateShortCode();
        Shortlink::updateOrCreate(
            ['article_id' => $article->id],
            [
                'short_code' => $shortCode,
                'target_url' => $targetUrl,
                'clicks' => 0,
            ]
        );

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->load('author');
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $authors = Author::active()->get();
        $categories = Category::active()->get();
        $shortlink = Shortlink::where('article_id', $article->id)->first();

        return view('admin.articles.edit', compact('article', 'authors', 'categories', 'shortlink'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $shortlink = Shortlink::where('article_id', $article->id)->first();

        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'author_id' => 'required|exists:authors,id',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'short_code' => ['nullable','alpha_dash','max:64', 'unique:shortlinks,short_code' . ($shortlink ? ',' . $shortlink->id : '')],
        ]);

        $article->update([
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'author_id' => $request->author_id,
            'status' => $request->status,
            'published_at' => $request->status === 'published' && !$article->published_at ? now() : $article->published_at,
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/articles', 'public');
            $article->image = asset('storage/' . $path);
            $article->save();
        }

        // Sync categories
        $article->categories()->sync($request->categories);

        // Update or create shortlink
        $targetUrl = route('article.detail', $article->slug);
        $customCode = $request->input('short_code');
        if ($shortlink) {
            // If custom short code provided, update it; else keep existing
            $shortlink->short_code = $customCode ?: $shortlink->short_code;
            $shortlink->target_url = $targetUrl;
            $shortlink->save();
        } else {
            $shortCode = $customCode ?: Shortlink::generateShortCode();
            Shortlink::create([
                'short_code' => $shortCode,
                'target_url' => $targetUrl,
                'article_id' => $article->id,
                'clicks' => 0,
            ]);
        }

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }
}
