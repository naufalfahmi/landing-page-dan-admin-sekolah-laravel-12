@extends('layouts.app')

@section('title', 'Galeri Foto Sekolah - ' . config('app.name'))

@section('description', 'Galeri foto kegiatan sekolah, ekstrakurikuler, acara sekolah, dan fasilitas. Lihat dokumentasi visual kegiatan dan fasilitas sekolah kami.')

@push('styles')
    <!-- Open Graph Meta Tags for Galleries Index -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Galeri Foto Sekolah - {{ config('app.name') }}">
    <meta property="og:description" content="Galeri foto kegiatan sekolah, ekstrakurikuler, acara sekolah, dan fasilitas. Lihat dokumentasi visual kegiatan dan fasilitas sekolah kami.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="id_ID">
    
    <!-- Twitter Card Meta Tags for Galleries Index -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Galeri Foto Sekolah - {{ config('app.name') }}">
    <meta name="twitter:description" content="Galeri foto kegiatan sekolah, ekstrakurikuler, acara sekolah, dan fasilitas. Lihat dokumentasi visual kegiatan dan fasilitas sekolah kami.">
@endpush

@section('content')
<main class="container mt-4">
    <!-- Page Header -->
    <header class="row mb-4">
        <div class="col-12">
            <h1 class="page-title">Galeri Foto</h1>
            <p class="page-subtitle">Kumpulan foto kegiatan dan fasilitas sekolah</p>
        </div>
    </header>


    <!-- Filter Section -->
    <section class="row mb-4">
        <div class="col-12">
            <div class="filter-section">
                <div class="filter-buttons">
                    <a href="{{ route('galleries.index') }}" class="filter-btn {{ !request('category') ? 'active' : '' }}">
                        Semua
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('galleries.index', ['category' => $category->slug]) }}" class="filter-btn {{ request('category') == $category->slug ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Grid -->
    <div class="photo-grid-widget">
        @forelse($galleries as $gallery)
        <div class="photo-item-widget" data-category="{{ $gallery->category ? $gallery->category->slug : '' }}">
            <div class="photo-container-widget">
                @if($gallery->image)
                    <a href="{{ route('galleries.show', $gallery->slug) }}" 
                       id="gallery-widget-{{ $gallery->id }}">
                        <img src="{{ asset('storage/' . ($gallery->thumbnail ?? $gallery->image)) }}" 
                             alt="{{ $gallery->title }}" 
                             loading="lazy" 
                             class="photo-image-widget">
                        <div class="photo-overlay-widget">
                            <div class="photo-actions-widget">
                                <span class="photo-btn-widget" onclick="event.stopPropagation();">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                            </div>
                            <div class="photo-info-widget">
                                <div class="photo-category-widget" style="background: {{ $gallery->category_color }}20; color: {{ $gallery->category_color }};">
                                    <i class="{{ $gallery->category_icon }}"></i> {{ $gallery->category_label }}
                                </div>
                                <h3 class="photo-title-widget">{{ $gallery->title }}</h3>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="gallery-placeholder">
                        <i class="fas fa-images"></i>
                        <div class="gallery-placeholder-overlay">
                            <div class="gallery-placeholder-actions">
                                <a href="{{ route('galleries.show', $gallery->slug) }}" class="gallery-btn-placeholder">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </div>
                            <div class="gallery-placeholder-info">
                                <div class="gallery-category-placeholder" style="background: {{ $gallery->category_color }}20; color: {{ $gallery->category_color }};">
                                    <i class="{{ $gallery->category_icon }}"></i> {{ $gallery->category_label }}
                                </div>
                                <h3 class="gallery-title-placeholder">{{ $gallery->title }}</h3>
                            </div>
                        </div>
                    </div>
                @endif
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

/* Gallery Grid - Using Masonry Style */
.photo-grid-widget {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.photo-item-widget {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.photo-item-widget:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.photo-container-widget {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.photo-image-widget {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.photo-item-widget:hover .photo-image-widget {
    transform: scale(1.05);
}

.photo-overlay-widget {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.4), rgba(0,0,0,0.2));
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1rem;
    opacity: 1;
    transition: all 0.3s ease;
}

.photo-item-widget:hover .photo-overlay-widget {
    background: linear-gradient(135deg, rgba(0,0,0,0.5), rgba(0,0,0,0.3));
}

.photo-actions-widget {
    display: flex;
    justify-content: flex-end;
}

.photo-btn-widget {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.9);
    color: #03aca5;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.photo-btn-widget:hover {
    background: #ffffff;
    color: #028a85;
    transform: scale(1.1);
}

.photo-info-widget {
    color: #ffffff;
}

.photo-category-widget {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    backdrop-filter: blur(10px);
}

.photo-title-widget {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
    color: #ffffff;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

/* Gallery Placeholder Styles */
.gallery-placeholder {
    position: relative;
    height: 250px;
    background: linear-gradient(135deg, #03aca5, #0d9488);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    border-radius: 15px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
}

.gallery-placeholder:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(3, 172, 165, 0.3);
}

.gallery-placeholder i {
    font-size: 4rem;
    opacity: 0.8;
}

.gallery-placeholder-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.4), rgba(0,0,0,0.2));
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1rem;
    opacity: 1;
    transition: all 0.3s ease;
}

.gallery-placeholder:hover .gallery-placeholder-overlay {
    background: linear-gradient(135deg, rgba(0,0,0,0.5), rgba(0,0,0,0.3));
}

.gallery-placeholder-actions {
    display: flex;
    justify-content: flex-end;
}

.gallery-btn-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.9);
    color: #03aca5;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
}

.gallery-btn-placeholder:hover {
    background: #ffffff;
    color: #028a85;
    transform: scale(1.1);
}

.gallery-placeholder-info {
    color: #ffffff;
}

.gallery-category-placeholder {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.gallery-title-placeholder {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
    color: #ffffff;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
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
        justify-content: center;
    }
    
    .photo-grid-widget {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
    }
    
    .photo-container-widget {
        height: 200px;
    }
    
    .gallery-placeholder {
        height: 200px;
    }
    
}

@media (max-width: 576px) {
    .photo-grid-widget {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .photo-container-widget {
        height: 180px;
    }
    
    .gallery-placeholder {
        height: 180px;
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

