@extends('layouts.app')

@section('title', 'Galeri Foto Sekolah - ' . config('app.name'))

@section('meta')
<meta name="description" content="Galeri foto kegiatan sekolah, ekstrakurikuler, acara sekolah, dan fasilitas. Lihat dokumentasi visual kegiatan dan fasilitas sekolah kami.">
<meta name="keywords" content="galeri foto sekolah, kegiatan sekolah, ekstrakurikuler, fasilitas sekolah, dokumentasi sekolah">
<meta property="og:title" content="Galeri Foto Sekolah - {{ config('app.name') }}">
<meta property="og:description" content="Galeri foto kegiatan sekolah, ekstrakurikuler, acara sekolah, dan fasilitas">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@endsection

@section('content')
<main class="container mt-4">
    <!-- Page Header -->
    <header class="row mb-4">
        <div class="col-12">
            <h1 class="page-title">Galeri Foto</h1>
            <p class="page-subtitle">Kumpulan foto kegiatan dan fasilitas sekolah</p>
        </div>
    </header>


    <!-- Category Filters -->
    <section class="row mb-4" aria-label="Filter Kategori Galeri">
        <div class="col-12">
            <div class="gallery-filters">
                <h2 class="visually-hidden">Filter Kategori Galeri</h2>
                <nav class="filter-buttons" role="tablist" aria-label="Kategori galeri">
                    <a href="{{ route('galleries.index') }}" 
                       class="filter-btn {{ !request('category') ? 'active' : '' }}"
                       role="tab"
                       aria-selected="{{ !request('category') ? 'true' : 'false' }}"
                       aria-label="Lihat semua foto galeri">
                        <i class="fas fa-th" aria-hidden="true"></i> Semua
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('galleries.index', ['category' => $category->slug]) }}" 
                       class="filter-btn {{ request('category') == $category->slug ? 'active' : '' }}"
                       role="tab"
                       aria-selected="{{ request('category') == $category->slug ? 'true' : 'false' }}"
                       aria-label="Lihat foto kategori {{ $category->name }}">
                        <i class="{{ $category->icon ?? 'fas fa-folder' }}" aria-hidden="true"></i> {{ $category->name }}
                    </a>
                    @endforeach
                </nav>
            </div>
        </div>
    </section>

    <!-- Gallery Grid -->
    <div class="photo-grid-widget">
        @forelse($galleries as $gallery)
        <div class="photo-item-widget" data-category="{{ $gallery->category ? $gallery->category->slug : '' }}">
            <div class="photo-container-widget">
                <a href="{{ asset('storage/' . $gallery->image) }}" 
                   id="gallery-item-{{ $gallery->id }}"
                   class="glightbox" 
                   data-gallery="gallery-main"
                   data-title="{{ $gallery->title }}"
                   data-description="{{ $gallery->description }}"
                   data-type="image">
                    <img src="{{ asset('storage/' . ($gallery->thumbnail ?? $gallery->image)) }}" 
                         alt="{{ $gallery->title }}" 
                         class="photo-image-widget"
                         loading="lazy">
                    <div class="photo-overlay-widget">
                        <div class="photo-actions-widget">
                            <a href="{{ route('galleries.show', $gallery->slug) }}" class="photo-btn-widget" onclick="event.stopPropagation();">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </div>
                        <div class="photo-info-widget">
                            <div class="photo-category-widget" style="background: {{ $gallery->category_color }}20; color: {{ $gallery->category_color }};">
                                <i class="{{ $gallery->category_icon }}"></i> {{ $gallery->category_label }}
                            </div>
                            <h3 class="photo-title-widget">{{ $gallery->title }}</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @empty
        <div class="photo-empty">
            <i class="fas fa-images fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Belum ada foto galeri</h4>
            <p class="text-muted">Foto galeri akan muncul di sini ketika tersedia.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($galleries->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="pagination-wrapper">
                <nav aria-label="Galeri navigation">
                    <ul class="pagination justify-content-center">
                        <!-- Previous Page -->
                        @if($galleries->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i> Sebelumnya
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $galleries->previousPageUrl() }}">
                                    <i class="fas fa-chevron-left"></i> Sebelumnya
                                </a>
                            </li>
                        @endif
                        
                        <!-- Page Numbers -->
                        @foreach($galleries->getUrlRange(1, $galleries->lastPage()) as $page => $url)
                            @if($page == $galleries->currentPage())
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
                        @if($galleries->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $galleries->nextPageUrl() }}">
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

/* Gallery Filters */
.gallery-filters {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 15px;
    margin-bottom: 2rem;
}

.filter-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    justify-content: center;
}

.filter-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: #ffffff;
    border: 2px solid #e9ecef;
    border-radius: 25px;
    color: #666;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.filter-btn:hover {
    background: #03aca5;
    border-color: #03aca5;
    color: #ffffff;
    text-decoration: none;
    transform: translateY(-2px);
}

.filter-btn.active {
    background: #03aca5;
    border-color: #03aca5;
    color: #ffffff;
}

/* Gallery Grid - Using Masonry Style */
.photo-grid-widget {
    margin-bottom: 3rem;
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

/* Page Header Styling - Same as Contact */
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

/* Responsive Design */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
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
    
}

@media (max-width: 576px) {
    .page-title {
        font-size: 1.75rem;
    }
}

/* GLightbox Custom Styles - Ensure full size display and perfect centering */
.glightbox-image img {
    max-width: none !important;
    max-height: none !important;
    width: auto !important;
    height: auto !important;
    object-fit: contain !important;
    display: block !important;
    margin: 0 auto !important;
}

.glightbox-image {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
    height: 100% !important;
    text-align: center !important;
}

/* Force lightbox to use full viewport */
.glightbox-container {
    width: 90vw !important;
    height: 90vh !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.glightbox-image-container {
    width: 100% !important;
    height: 100% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    text-align: center !important;
}

/* Additional centering for the lightbox content */
.glightbox-content {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
    height: 100% !important;
}

/* Center the lightbox modal itself */
.glightbox {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}
</style>
@endpush

