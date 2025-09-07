@extends('layouts.app')

@php
    $siteTitle = \App\Models\Setting::getValue('site_title', 'SMPIT Al-Itqon');
    $siteSubtitle = \App\Models\Setting::getValue('site_subtitle', 'Berita dan Artikel Islami');
@endphp
@section('title', $siteTitle . ' - ' . $siteSubtitle)

@section('content')
<!-- Hero Slider Section -->
@include('components.hero-slider')

<!-- Announcements Widget -->
@include('components.announcements-widget')

<!-- Documents Widget -->
@include('components.documents-widget')

<!-- Gallery Widget -->
@include('components.gallery-widget')

<!-- Articles Section -->
<div class="articles-widget">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="widget-header">
                    <h3 class="widget-title">
                        <i class="fas fa-newspaper"></i>
                        Berita Seputar SMP
                    </h3>
                    <a href="{{ route('articles.index') }}" class="view-all-btn">
                        Semua Berita <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
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
</div>
@endsection
