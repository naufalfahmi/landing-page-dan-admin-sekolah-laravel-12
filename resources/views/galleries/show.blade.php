@extends('layouts.app')

@section('title', $gallery->title . ' - Galeri Foto')
@section('description', $gallery->description)

@push('styles')
    <!-- Open Graph Meta Tags for Gallery -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $gallery->title }} - Galeri Foto">
    <meta property="og:description" content="{{ $gallery->description }}">
    <meta property="og:url" content="{{ request()->url() }}">
    @if($gallery->image)
        <meta property="og:image" content="{{ asset('storage/' . $gallery->image) }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:type" content="image/jpeg">
    @endif
    <meta property="og:locale" content="id_ID">
    <meta property="article:author" content="SMPIT Al-Itqon">
    <meta property="article:published_time" content="{{ $gallery->created_at->toISOString() }}">
    <meta property="article:section" content="Galeri Foto">
    @if($gallery->category)
        <meta property="article:tag" content="{{ $gallery->category->name }}">
    @endif
    
    <!-- Twitter Card Meta Tags for Gallery -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $gallery->title }} - Galeri Foto">
    <meta name="twitter:description" content="{{ $gallery->description }}">
    @if($gallery->image)
        <meta name="twitter:image" content="{{ asset('storage/' . $gallery->image) }}">
    @endif
@endpush

@section('content')
<div class="container mt-4">
    <!-- Breadcrumb Section -->
    <nav aria-label="breadcrumb" class="breadcrumb-section">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('galleries.index') }}">
                        <i class="fas fa-images"></i> Galeri Foto
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-camera"></i> {{ Str::limit($gallery->title, 50) }}
                </li>
            </ol>
        </div>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="gallery-detail">
                <!-- Header -->
                <div class="gallery-header mb-4">
                    <div class="gallery-meta mb-3">
                        <span class="badge bg-{{ $gallery->category_color }}">
                            <i class="{{ $gallery->category_icon }}"></i> {{ $gallery->category_label }}
                        </span>
                    </div>
                    
                    <h1 class="gallery-title">{{ $gallery->title }}</h1>
                    
                    <div class="gallery-stats">
                        <small class="text-muted">
                            <i class="fas fa-eye"></i> {{ $gallery->views }} kali dilihat
                        </small>
                    </div>
                </div>

                <!-- Image -->
                <div class="gallery-image-detail">
                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="img-fluid rounded">
                </div>

                <!-- Next/Prev Navigation -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    @if($previousGallery)
                        <a href="{{ route('galleries.show', $previousGallery->slug) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Sebelumnya
                        </a>
                    @else
                        <span></span>
                    @endif

                    @if($nextGallery)
                        <a href="{{ route('galleries.show', $nextGallery->slug) }}" class="btn btn-outline-secondary">
                            Selanjutnya <i class="fas fa-arrow-right"></i>
                        </a>
                    @endif
                </div>

                <!-- Description -->
                @if($gallery->description)
                <div class="gallery-description mt-4">
                    <h4>Deskripsi</h4>
                    <p>{{ $gallery->description }}</p>
                </div>
                @endif

                <!-- Actions -->
                <div class="gallery-actions mt-4">
                    <a href="{{ route('galleries.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Galeri
                    </a>
                    
                    <div class="float-end">
                        <button class="btn btn-outline-secondary" onclick="window.print()">
                            <i class="fas fa-print"></i> Cetak
                        </button>
                    </div>
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related Galleries -->
            @if($relatedGalleries->count() > 0)
            <div class="sidebar-widget">
                <h4 class="widget-title">Galeri Terkait</h4>
                <div class="related-galleries">
                    @foreach($relatedGalleries as $related)
                    <div class="related-item">
                        <div class="related-image">
                            <a href="{{ route('galleries.show', $related->slug) }}" class="text-decoration-none">
                                <img src="{{ asset('storage/' . ($related->thumbnail ?? $related->image)) }}" alt="{{ $related->title }}" class="img-fluid">
                            </a>
                        </div>
                        <div class="related-info">
                            <h6>
                                <a href="{{ route('galleries.show', $related->slug) }}" class="text-decoration-none">
                                    {{ $related->title }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="fas fa-eye"></i> {{ $related->views }} kali dilihat
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Quick Links -->
            <div class="sidebar-widget">
                <h4 class="widget-title">Kategori Galeri</h4>
                <div class="quick-links">
                    <a href="{{ route('galleries.index') }}" class="quick-link">
                        <i class="fas fa-th"></i> Semua Galeri
                    </a>
                    <a href="{{ route('galleries.index', ['category' => 'kegiatan-belajar']) }}" class="quick-link">
                        <i class="fas fa-book"></i> Kegiatan Belajar
                    </a>
                    <a href="{{ route('galleries.index', ['category' => 'ekstrakurikuler']) }}" class="quick-link">
                        <i class="fas fa-futbol"></i> Ekstrakurikuler
                    </a>
                    <a href="{{ route('galleries.index', ['category' => 'acara-sekolah']) }}" class="quick-link">
                        <i class="fas fa-calendar-check"></i> Acara Sekolah
                    </a>
                    <a href="{{ route('galleries.index', ['category' => 'fasilitas']) }}" class="quick-link">
                        <i class="fas fa-building"></i> Fasilitas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.gallery-detail {
    background: #ffffff;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.gallery-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #333;
    line-height: 1.3;
    margin-bottom: 1rem;
}

.gallery-meta .badge {
    font-size: 0.9rem;
    padding: 0.6rem 1.2rem;
}

.gallery-image-detail img {
    width: 100%;
    height: auto;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.gallery-description h4 {
    color: #333;
    margin-bottom: 1rem;
    font-size: 1.3rem;
}

.gallery-description p {
    color: #666;
    line-height: 1.8;
    font-size: 1.1rem;
}

.gallery-actions {
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
}

.sidebar-widget {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 15px;
    margin-bottom: 2rem;
}

.widget-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #03aca5;
}

.related-item {
    display: flex;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #e9ecef;
}

.related-item:last-child {
    border-bottom: none;
}

.related-image {
    width: 80px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.related-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.related-info h6 {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.related-info a {
    color: #333;
    transition: color 0.3s ease;
}

.related-info a:hover {
    color: #03aca5;
}

.quick-links {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.quick-link {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.8rem 1rem;
    background: #ffffff;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.quick-link:hover {
    background: #03aca5;
    color: #ffffff;
    text-decoration: none;
    transform: translateX(5px);
}

@media (max-width: 768px) {
    .gallery-detail {
        padding: 1.5rem;
    }
    
    .gallery-title {
        font-size: 1.8rem;
    }
    
    .gallery-actions {
        text-align: center;
    }
    
    .gallery-actions .float-end {
        float: none !important;
        margin-top: 1rem;
    }
}
</style>
@endpush
