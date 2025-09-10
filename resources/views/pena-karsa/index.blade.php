@extends('layouts.app')

@section('title', 'Pena Karsa - Ruang Ekspresi - ' . config('app.name'))

@section('content')
<main class="container mt-4">
    <!-- Page Header -->
    <header class="row mb-4">
        <div class="col-12">
            <h1 class="page-title">Pena Karsa</h1>
            <p class="page-subtitle">Ruang ekspresi untuk tulisan dan karya kreatif siswa serta guru</p>
        </div>
    </header>

    <!-- Filter Section -->
    <section class="row mb-4">
        <div class="col-12">
            <div class="filter-section">
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
    </section>

    <!-- Articles Grid -->
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
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <div class="pena-karsa-author">
                            <i class="fas fa-user-circle"></i>
                            <span class="author-name">{{ $item->author_name }}</span>
                            @if($item->author_position)
                                <span class="author-position">({{ $item->author_position }})</span>
                            @elseif($item->author_class)
                                <span class="author-class">({{ $item->author_class }})</span>
                            @endif
                        </div>
                    </div>
                    <h2 class="card-title pena-karsa-title" itemprop="headline">
                        <a href="{{ route('pena-karsa.show', $item->slug) }}" class="pena-karsa-title-link" itemprop="mainEntityOfPage url">{{ $item->title }}</a>
                    </h2>
                    <p class="card-text pena-karsa-excerpt">{{ $item->excerpt }}</p>
                    
                    @if(count($item->getCleanTags()) > 0)
                        <div class="pena-karsa-tags mb-3">
                            @foreach($item->getCleanTags() as $tag)
                                <span class="pena-karsa-tag">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="entry-meta pena-karsa-meta mt-auto">
                        <span class="posted-on">
                            <i class="fas fa-calendar-alt"></i>
                            <time class="entry-date published" datetime="{{ $item->published_at->format('Y-m-d') }}" itemprop="datePublished">{{ $item->published_at->format('d M Y') }}</time>
                        </span>
                        <span class="pena-karsa-views">
                            <i class="fas fa-eye"></i>
                            {{ $item->views ?? 0 }}
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
                <h2 class="text-muted">Belum ada tulisan</h2>
                <p class="text-muted">Tulisan akan muncul di sini ketika tersedia.</p>
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
</main>
@endsection

@push('styles')
<style>
/* Page Header Styling - Same as other pages */
.page-title {
    color: #03aca5;
    font-weight: 800;
    text-align: center;
    margin-bottom: 1rem;
    position: relative;
}

.page-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #03aca5, #02d4c7);
    border-radius: 2px;
}

.page-subtitle {
    color: #666;
    text-align: center;
    font-weight: 500;
    font-size: 1.1rem;
}

/* Filter Section Styling */
.filter-section {
    background: linear-gradient(135deg, #ffffff 0%, #f8fffe 100%);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(3, 172, 165, 0.1);
    border: 1px solid rgba(3, 172, 165, 0.1);
    margin-bottom: 2rem;
}

.filter-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
}

.filter-btn {
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border: 2px solid rgba(3, 172, 165, 0.2);
    color: #666;
    background: #ffffff;
}

.filter-btn:hover {
    background: #03aca5;
    color: #ffffff;
    border-color: #03aca5;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(3, 172, 165, 0.3);
}

.filter-btn.active {
    background: linear-gradient(135deg, #03aca5, #028a85);
    color: #ffffff;
    border-color: #03aca5;
    box-shadow: 0 4px 15px rgba(3, 172, 165, 0.3);
}

/* Pena Karsa Card Styling */
.pena-karsa-card {
    border: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.pena-karsa-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.pena-karsa-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.pena-karsa-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.pena-karsa-card:hover .pena-karsa-image {
    transform: scale(1.05);
}

.pena-karsa-placeholder {
    height: 200px;
    background: linear-gradient(135deg, #03aca5, #0d9488);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
}

.pena-karsa-placeholder i {
    font-size: 3rem;
}

.pena-karsa-type-badge {
    position: absolute;
    top: 15px;
    right: 15px;
}

.pena-karsa-author {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.pena-karsa-author i {
    color: #03aca5;
}

.author-name {
    font-weight: 600;
}

.author-position,
.author-class {
    color: #999;
    font-size: 0.8rem;
}

.pena-karsa-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.pena-karsa-title-link {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.pena-karsa-title-link:hover {
    color: #03aca5;
}

.pena-karsa-excerpt {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.pena-karsa-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.pena-karsa-tag {
    background: linear-gradient(135deg, #03aca5, #028a85);
    color: #ffffff;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 500;
}

.pena-karsa-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #999;
    font-size: 0.85rem;
    padding-top: 0.5rem;
    border-top: 1px solid #eee;
}

.pena-karsa-meta .posted-on {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.pena-karsa-meta .pena-karsa-views {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Type Badge Styling */
.type-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    color: #ffffff;
    margin-right: 0.5rem;
}

.type-badge.type-article {
    background: linear-gradient(135deg, #3498db, #2980b9);
}

.type-badge.type-opinion {
    background: #10b981;
    color: #fff;
}

.type-badge.type-essay {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

.type-badge.type-motivation {
    background: linear-gradient(135deg, #27ae60, #229954);
}

.type-badge.type-creative {
    background: linear-gradient(135deg, #9b59b6, #8e44ad);
}

/* Featured Badge */
.featured-badge {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: #ffffff;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .filter-section {
        padding: 1.5rem;
    }
    
    .filter-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .filter-btn {
        width: 100%;
        max-width: 200px;
    }
    
    .page-title {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .page-title {
        font-size: 1.75rem;
    }
}
</style>
@endpush
