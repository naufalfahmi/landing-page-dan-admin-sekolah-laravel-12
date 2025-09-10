@extends('layouts.app')

@php
    $siteTitle = \App\Models\Setting::getValue('site_title', 'SMPIT Al-Itqon');
    $siteSubtitle = \App\Models\Setting::getValue('site_subtitle', 'Berita dan Artikel Islami');
    $metaDescription = \App\Models\Setting::getValue('meta_description', 'Portal berita dan artikel Islami dari SMPIT Al-Itqon. Dapatkan informasi terbaru seputar pendidikan, kegiatan sekolah, dan konten inspiratif untuk siswa dan orang tua.');
    $siteLogo = \App\Models\Setting::getValue('site_logo');
@endphp
@section('title', $siteTitle . ' - ' . $siteSubtitle)
@section('description', $metaDescription)

@push('styles')
<!-- Additional Open Graph Meta Tags for Homepage -->
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $siteTitle }} - {{ $siteSubtitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ url('/') }}">
@if(!empty($siteLogo))
    <meta property="og:image" content="{{ $siteLogo }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/png">
@endif
<meta property="og:locale" content="id_ID">

<!-- Twitter Card Meta Tags for Homepage -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $siteTitle }} - {{ $siteSubtitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
@if(!empty($siteLogo))
    <meta name="twitter:image" content="{{ $siteLogo }}">
@endif
@endpush

@section('content')
<!-- Hero Banner Section -->
@include('components.hero-banner')

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
                <div class="article-image-container">
                    @if($article->image)
                        <img src="{{ $article->image }}" class="card-img-top article-image" alt="{{ $article->title }}" itemprop="image">
                    @else
                        <div class="article-placeholder">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    @endif
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

<!-- Pena Karsa Section -->
<div class="pena-karsa-widget">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="widget-header">
                    <h3 class="widget-title">
                        <i class="fas fa-pen-fancy"></i>
                        Pena Karsa
                    </h3>
                    @if($penaKarsa && count($penaKarsa) > 0)
                    <a href="{{ route('pena-karsa.index') }}" class="view-all-btn">
                        Semua Karya <i class="fas fa-arrow-right"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    
        <div class="row">
            @forelse($penaKarsa as $item)
            <div class="col-md-4 mb-4">
                <article class="card pena-karsa-card h-100" itemscope itemtype="https://schema.org/Article">
                    <div class="pena-karsa-image-container">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top pena-karsa-image" alt="{{ $item->title }}" itemprop="image">
                        @else
                            <div class="pena-karsa-placeholder">
                                <i class="fas fa-pen-fancy"></i>
                            </div>
                        @endif
                        <div class="pena-karsa-type-badge">
                            <span class="type-badge type-{{ $item->type }}">{{ $item->type_display }}</span>
                        </div>
                        @if($item->is_featured)
                        <div class="pena-karsa-featured">
                            <i class="fas fa-star"></i>
                        </div>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <div class="pena-karsa-author">
                                <i class="fas fa-user-circle"></i>
                                <span class="author-name">{{ $item->author_name }}</span>
                                @if($item->author_type === 'student' && $item->author_class)
                                    <span class="author-class">({{ $item->author_class }})</span>
                                @elseif($item->author_type === 'teacher' && $item->author_position)
                                    <span class="author-position">({{ $item->author_position }})</span>
                                @endif
                            </div>
                        </div>
                        <h2 class="card-title pena-karsa-title" itemprop="headline">
                            <a href="{{ route('pena-karsa.show', $item->slug) }}" class="pena-karsa-title-link" itemprop="mainEntityOfPage url">{{ $item->title }}</a>
                        </h2>
                        <p class="card-text pena-karsa-excerpt">{{ Str::limit(strip_tags($item->excerpt), 100) }}</p>
                        
                        @php
                            $cleanTags = $item->getCleanTags();
                        @endphp
                        @if(count($cleanTags) > 0)
                        <div class="pena-karsa-tags mb-3">
                            @foreach(array_slice($cleanTags, 0, 3) as $tag)
                                <span class="pena-karsa-tag">{{ $tag }}</span>
                            @endforeach
                            @if(count($cleanTags) > 3)
                                <span class="pena-karsa-tag-more">+{{ count($cleanTags) - 3 }}</span>
                            @endif
                        </div>
                        @endif
                        
                        <div class="entry-meta pena-karsa-meta mt-auto">
                            <span class="posted-on">
                                <i class="fas fa-calendar-alt"></i>
                                <time class="entry-date published" datetime="{{ $item->published_at->format('Y-m-d') }}" itemprop="datePublished">{{ $item->published_at->format('d M Y') }}</time>
                            </span>
                            <span class="pena-karsa-views">
                                <i class="fas fa-eye"></i>
                                {{ number_format($item->views) }}
                            </span>
                        </div>
                        <div class="visually-hidden" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                            <meta itemprop="name" content="{{ config('app.name') }}">
                            <meta itemprop="url" content="{{ url('/') }}">
                        </div>
                    </div>
                </article>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-pen-fancy fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada tulisan</h4>
                    <p class="text-muted">Tulisan akan muncul di sini ketika tersedia.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
/* Article Image Container and Placeholder */
.article-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.article-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.card:hover .article-image {
    transform: scale(1.05);
}

.article-placeholder {
    height: 200px;
    background: linear-gradient(135deg, #03aca5, #0d9488);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
}

.article-placeholder i {
    font-size: 3rem;
}
</style>
@endsection
