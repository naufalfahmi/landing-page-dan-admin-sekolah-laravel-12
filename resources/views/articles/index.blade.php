@extends('layouts.app')

@section('title', 'Semua Berita - ' . config('app.name'))
@section('description', 'Kumpulan artikel dan berita terbaru dari sekolah: kajian Al-Quran, hadis, fikih, adab, opini, tokoh, dan lainnya.')

@section('content')
<div class="container mt-4">
    <!-- Page Header -->
    <header class="row mb-4">
        <div class="col-12">
            <h1 class="page-title">Berita</h1>
            <p class="page-subtitle">Kumpulan artikel dan berita terbaru dari sekolah</p>
        </div>
    </header>

    <!-- Category Filters -->
    <section class="row mb-4" aria-label="Filter Kategori Berita">
        <div class="col-12">
            <div class="article-filters">
                <h2 class="visually-hidden">Filter Kategori Berita</h2>
                <nav class="filter-buttons" role="tablist" aria-label="Kategori berita">
                    <a href="{{ route('articles.index') }}" 
                       class="filter-btn {{ !request('category') ? 'active' : '' }}"
                       role="tab"
                       aria-selected="{{ !request('category') ? 'true' : 'false' }}"
                       aria-label="Lihat semua berita">
                        <i class="fas fa-newspaper" aria-hidden="true"></i> Semua
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('articles.index', ['category' => $category->slug]) }}" 
                       class="filter-btn {{ request('category') == $category->slug ? 'active' : '' }}"
                       role="tab"
                       aria-selected="{{ request('category') == $category->slug ? 'true' : 'false' }}"
                       aria-label="Lihat berita kategori {{ $category->name }}">
                        <i class="fas fa-tag" aria-hidden="true"></i> {{ $category->name }}
                    </a>
                    @endforeach
                </nav>
            </div>
        </div>
    </section>

    <!-- Articles Grid -->
    <div class="row">
        @forelse($articles as $article)
        <div class="col-lg-4 col-md-6 mb-4">
            <article class="card h-100 article-card" itemscope itemtype="https://schema.org/Article">
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
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada artikel</h4>
                <p class="text-muted">Artikel akan muncul di sini ketika tersedia.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="pagination-wrapper">
                <nav aria-label="Artikel navigation">
                    <ul class="pagination justify-content-center">
                        <!-- Previous Page -->
                        @if($articles->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i> Sebelumnya
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $articles->previousPageUrl() }}">
                                    <i class="fas fa-chevron-left"></i> Sebelumnya
                                </a>
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
                                <a class="page-link" href="{{ $articles->nextPageUrl() }}">
                                    Selanjutnya <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">
                                    Selanjutnya <i class="fas fa-chevron-right"></i>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 0;
}

.article-card {
    border: 1px solid #e9ecef;
    border-radius: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
}

.article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.article-image {
    overflow: hidden;
    height: 200px;
}

.article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.article-card:hover .article-image img {
    transform: scale(1.05);
}

.article-title-link {
    color: #333;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    line-height: 1.4;
    transition: color 0.3s ease;
}

.article-title-link:hover {
    color: #03aca5;
    text-decoration: none;
}

.article-excerpt {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.5;
}

.entry-taxonomies {
    font-size: 0.8rem;
}

.entry-taxonomies a {
    color: #03aca5;
    text-decoration: none;
    font-weight: 500;
}

.entry-taxonomies a:hover {
    text-decoration: underline;
}

.entry-meta {
    font-size: 0.85rem;
    color: #888;
}

.entry-meta a {
    color: #03aca5;
    text-decoration: none;
}

.entry-meta a:hover {
    text-decoration: underline;
}

/* Pagination Styles */
.pagination-wrapper {
    margin-top: 3rem;
    padding: 2rem 0;
}

.pagination {
    margin: 0;
    gap: 0.5rem;
}

.pagination .page-item {
    margin: 0;
}

.pagination .page-link {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    color: #666;
    font-weight: 500;
    transition: all 0.3s ease;
    background: #ffffff;
    min-width: 45px;
    text-align: center;
}

.pagination .page-link:hover {
    background: #03aca5;
    border-color: #03aca5;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(3, 172, 165, 0.3);
}

.pagination .page-item.active .page-link {
    background: #03aca5;
    border-color: #03aca5;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(3, 172, 165, 0.3);
}

.pagination .page-item.disabled .page-link {
    background: #f8f9fa;
    border-color: #e9ecef;
    color: #adb5bd;
    cursor: not-allowed;
}

.pagination .page-link i {
    font-size: 0.8rem;
}

/* Page Header Styling - Same as Contact and Gallery */
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

/* Article Filters */
.article-filters {
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
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-btn:hover {
    background: #03aca5;
    color: #ffffff;
    border-color: #03aca5;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(3, 172, 165, 0.3);
    text-decoration: none;
}

.filter-btn.active {
    background: linear-gradient(135deg, #03aca5, #028a85);
    color: #ffffff;
    border-color: #03aca5;
    box-shadow: 0 4px 15px rgba(3, 172, 165, 0.3);
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .article-filters {
        padding: 1.5rem;
    }
    
    .filter-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .filter-btn {
        width: 100%;
        max-width: 200px;
        justify-content: center;
    }
    
    .article-image {
        height: 180px;
    }
    
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .pagination .page-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
        min-width: 40px;
    }
    
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-size: 0.8rem;
        padding: 0.5rem 0.6rem;
    }
}

@media (max-width: 576px) {
    .page-title {
        font-size: 1.75rem;
    }
}
</style>
@endpush
