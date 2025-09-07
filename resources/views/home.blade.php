@extends('layouts.app')

@section('title', 'Portal Islam - Berita dan Artikel Islami')

@section('content')
<!-- Hero Slider Section -->
@include('components.hero-slider')

<!-- Articles Section -->
<div class="container mt-4" id="articles">
    <!-- Section Heading -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="section-heading text-center">Berita Seputar SMP</h2>
        </div>
    </div>
    
    <div class="row">
        @foreach($articles as $article)
        <div class="col-md-4 mb-4">
            <article class="card h-100" itemscope itemtype="https://schema.org/Article">
                <img src="{{ $article->image }}" class="card-img-top" alt="{{ $article->title }}" itemprop="image">
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
                    <div class="entry-meta entry-meta-divider-dot mt-auto">
                        <span class="posted-by">
                            <span class="meta-label">By</span>
                            <span class="author vcard" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                <a class="url fn n" href="{{ route('author.show', $article->author->slug ?? '') }}" itemprop="url">
                                    <span itemprop="name">{{ $article->author->name ?? 'Unknown' }}</span>
                                </a>
                            </span>
                        </span>
                        <span class="posted-on">
                            <time class="entry-date published" datetime="{{ $article->published_at->format('Y-m-d') }}" itemprop="datePublished">{{ $article->published_at->format('d M Y') }}</time>
                        </span>
                    </div>
                    <div class="visually-hidden" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                        <meta itemprop="name" content="{{ config('app.name') }}">
                        <meta itemprop="url" content="{{ url('/') }}">
                    </div>
                </div>
            </article>
        </div>
        @endforeach
    </div>
    
    <!-- Custom Pagination -->
    @if($articles->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Artikel navigation">
            <ul class="pagination pagination-sm">
                <!-- Previous Page -->
                @if($articles->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Sebelumnya</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $articles->previousPageUrl() }}">Sebelumnya</a>
                    </li>
                @endif
                
                <!-- Page Numbers -->
                @foreach($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                    @if($page == $articles->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
                
                <!-- Next Page -->
                @if($articles->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $articles->nextPageUrl() }}">Selanjutnya</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Selanjutnya</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
</div>
@endsection
