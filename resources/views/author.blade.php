@extends('layouts.app')

@section('title', $author->name . ' - ' . config('app.name'))
@section('description', $author->bio ? Str::limit(strip_tags($author->bio), 150) : 'Profil penulis dan daftar artikel')

@push('styles')
    <!-- Open Graph Meta Tags for Author -->
    <meta property="og:type" content="profile">
    <meta property="og:title" content="{{ $author->name }} - {{ config('app.name') }}">
    <meta property="og:description" content="{{ $author->bio ? Str::limit(strip_tags($author->bio), 150) : 'Profil penulis dan daftar artikel' }}">
    <meta property="og:url" content="{{ request()->url() }}">
    @if(!empty($author->avatar))
        @section('og_image')
            <meta property="og:image" content="{{ $author->avatar }}">
        @endsection
        @section('twitter_image')
            <meta name="twitter:image" content="{{ $author->avatar }}">
        @endsection
    @endif
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card Meta Tags for Author -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $author->name }} - {{ config('app.name') }}">
    <meta name="twitter:description" content="{{ $author->bio ? Str::limit(strip_tags($author->bio), 150) : 'Profil penulis dan daftar artikel' }}">
@endpush

@section('content')
<div class="author-hero">
    <div class="container">
        <div class="author-card">
            <div class="author-avatar">
                @php
                    $name = $author->name;
                    $parts = preg_split('/\s+/', trim($name));
                    $initials = '';
                    foreach ($parts as $p) { $initials .= mb_strtoupper(mb_substr($p, 0, 1)); if (mb_strlen($initials) >= 2) break; }
                @endphp
                @if(!empty($author->avatar))
                    <img src="{{ $author->avatar }}" alt="{{ $author->name }}">
                @else
                    <div class="avatar-fallback">{{ $initials }}</div>
                @endif
            </div>
            <div class="author-info text-center text-md-start">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-2 mb-2">
                    <h1 class="author-name mb-0">{{ $author->name }}</h1>
                    @if($author->specialization)
                        <span class="badge author-badge">{{ $author->specialization }}</span>
                    @endif
                </div>
                @if($author->bio)
                    <p class="author-bio mb-3">{!! nl2br(e(Str::limit($author->bio, 220))) !!}</p>
                @endif
                <div class="author-stats">
                    <span class="chip"><i class="fas fa-newspaper"></i> {{ $articles->total() }} Artikel</span>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="container mt-4">
    <!-- Articles Grid -->
    <div class="row">
        @forelse($articles as $article)
        <div class="col-xl-4 col-md-6 mb-4">
            <article class="card h-100 author-article-card" itemscope itemtype="https://schema.org/Article">
                <div class="article-image">
                    <img src="{{ $article->image }}" class="card-img-top" alt="{{ $article->title }}" itemprop="image">
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <div class="entry-taxonomies">
                            <span class="category-links term-links category-style-normal">
                                @foreach($article->categories as $category)
                                    <a href="{{ route('category.show', $category->slug) }}" rel="tag" @if($loop->first) itemprop="articleSection" @endif>{{ $category->name }}</a>@if(!$loop->last) | @endif
                                @endforeach
                            </span>
                        </div>
                    </div>
                    <h2 class="card-title" itemprop="headline">
                        <a href="{{ route('article.detail', $article->slug) }}" class="article-title-link" itemprop="mainEntityOfPage url">{{ $article->title }}</a>
                    </h2>
                    <p class="card-text article-excerpt">{{ Str::limit($article->excerpt, 120) }}</p>
                    <div class="entry-meta entry-meta-divider-dot mt-auto">
                        <span class="posted-on">
                            <time class="entry-date published" datetime="{{ $article->published_at->format('Y-m-d') }}" itemprop="datePublished">{{ $article->published_at->format('d M Y') }}</time>
                        </span>
                    </div>
                </div>
            </article>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada artikel</h4>
                <p class="text-muted">Artikel dari penulis ini akan muncul di sini ketika tersedia.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="pagination-wrapper">
                {{ $articles->withQueryString()->links() }}
            </div>
        </div>
    </div>
    @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.author-hero { background: linear-gradient(135deg, #f0fdfa 0%, #e6fffa 100%); padding: 3rem 0 5rem; position: relative; }
.author-card { background: #ffffff; border-radius: 20px; box-shadow: 0 12px 30px rgba(3,172,165,0.15); padding: 1.25rem 1.25rem 1.25rem 1.25rem; display: flex; gap: 1rem; align-items: center; position: relative; top: 40px; border: 1px solid rgba(3,172,165,0.12); }
.author-avatar { width: 96px; height: 96px; border-radius: 50%; overflow: hidden; flex-shrink: 0; position: relative; box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
.author-avatar::after { content: ''; position: absolute; inset: -3px; border-radius: 50%; background: linear-gradient(135deg, #03aca5, #0d9488); z-index: -1; }
.author-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 4px solid #ffffff; }
.avatar-fallback { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; font-weight: 800; font-size: 1.4rem; border: 4px solid #ffffff; }
.author-info { flex: 1; }
.author-name { font-size: 1.6rem; font-weight: 800; color: #1f2937; }
.author-badge { background: rgba(3,172,165,0.12); color: #028a85; border: 1px solid rgba(3,172,165,0.3); padding: .35rem .6rem; border-radius: 999px; font-weight: 600; }
.author-bio { color: #4b5563; max-width: 70ch; }
.author-stats .chip { display: inline-flex; align-items: center; gap: .5rem; background: #f1f5f9; color: #0f172a; padding: .4rem .7rem; border-radius: 999px; font-size: .9rem; border: 1px solid #e2e8f0; }
.author-stats .chip i { color: #028a85; }

.author-article-card { border: 1px solid #e9ecef; border-radius: 15px; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; }
.author-article-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
.article-image { overflow: hidden; height: 200px; }
.article-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
.author-article-card:hover .article-image img { transform: scale(1.05); }
.article-title-link { color: #333; text-decoration: none; font-weight: 600; font-size: 1.1rem; line-height: 1.4; transition: color 0.3s ease; }
.article-title-link:hover { color: #03aca5; text-decoration: none; }
.pagination-wrapper { margin-top: 1rem; }
@media (max-width: 992px) { .author-card { flex-direction: column; text-align: center; gap: .75rem; padding: 1rem; } .author-info { text-align: center; } }
@media (max-width: 768px) { .article-image { height: 180px; } .author-name { font-size: 1.35rem; } .author-hero { padding: 2rem 0 4rem; } .author-card { top: 30px; } }
</style>
@endpush


