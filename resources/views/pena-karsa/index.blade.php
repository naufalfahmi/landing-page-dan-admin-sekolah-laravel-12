@extends('layouts.app')

@section('title', 'Pena Karsa - Ruang Ekspresi - ' . config('app.name'))

@section('content')
<div class="container mt-4">
    <!-- Page Header -->
    <header class="row mb-5">
        <div class="col-12">
            <div class="pena-karsa-page-header">
                <div class="header-content">
                    <h1 class="page-title pena-karsa-page-title">
                        <i class="fas fa-pen-fancy"></i>
                        Pena Karsa
                    </h1>
                    <p class="page-subtitle pena-karsa-page-subtitle">Ruang Ekspresi</p>
                    <span class="pena-karsa-page-tagline">Tulisan & Karya Kreatif</span>
                </div>
                <div class="header-decoration">
                    <div class="decoration-circle-large"></div>
                    <div class="decoration-line-large"></div>
                </div>
            </div>
        </div>
    </header>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="pena-karsa-filters">
                <div class="filter-buttons">
                    <a href="{{ route('pena-karsa.index') }}" class="filter-btn {{ request('type') == null ? 'active' : '' }}">
                        Semua
                    </a>
                    <a href="{{ route('pena-karsa.index', ['type' => 'article']) }}" class="filter-btn {{ request('type') == 'article' ? 'active' : '' }}">
                        Artikel
                    </a>
                    <a href="{{ route('pena-karsa.index', ['type' => 'opinion']) }}" class="filter-btn {{ request('type') == 'opinion' ? 'active' : '' }}">
                        Opini
                    </a>
                    <a href="{{ route('pena-karsa.index', ['type' => 'essay']) }}" class="filter-btn {{ request('type') == 'essay' ? 'active' : '' }}">
                        Esai
                    </a>
                    <a href="{{ route('pena-karsa.index', ['type' => 'motivation']) }}" class="filter-btn {{ request('type') == 'motivation' ? 'active' : '' }}">
                        Motivasi
                    </a>
                    <a href="{{ route('pena-karsa.index', ['type' => 'creative']) }}" class="filter-btn {{ request('type') == 'creative' ? 'active' : '' }}">
                        Kreatif
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="row">
        @forelse($penaKarsa as $item)
        <div class="col-lg-4 col-md-6 mb-4">
            <article class="card h-100 pena-karsa-card" itemscope itemtype="https://schema.org/Article">
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
                    <p class="card-text pena-karsa-excerpt">{{ Str::limit(strip_tags($item->excerpt), 120) }}</p>
                    
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
            <div class="pena-karsa-empty">
                <div class="empty-content">
                    <i class="fas fa-pen-fancy empty-icon"></i>
                    <h3>Belum Ada Karya</h3>
                    <p>Belum ada tulisan kreatif yang dipublikasikan. Kembali lagi nanti untuk melihat karya terbaru!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($penaKarsa->hasPages())
    <div class="row mt-5">
        <div class="col-12 d-flex justify-content-center">
            {{ $penaKarsa->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
