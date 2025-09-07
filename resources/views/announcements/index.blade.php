@extends('layouts.app')

@section('title', 'Pengumuman Sekolah - ' . config('app.name'))

@section('meta')
<meta name="description" content="Daftar pengumuman terbaru dan informasi penting dari sekolah. Temukan pengumuman akademik, kegiatan, ujian, dan libur sekolah.">
<meta name="keywords" content="pengumuman sekolah, informasi sekolah, berita sekolah, akademik, kegiatan sekolah">
<meta property="og:title" content="Pengumuman Sekolah - {{ config('app.name') }}">
<meta property="og:description" content="Daftar pengumuman terbaru dan informasi penting dari sekolah">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@endsection

@section('content')
<main class="container mt-4">
    <!-- Page Header -->
    <header class="row mb-4">
        <div class="col-12">
            <h1 class="page-title">Pengumuman</h1>
            <p class="page-subtitle">Informasi terbaru dan pengumuman penting dari sekolah</p>
        </div>
    </header>

    <!-- Filter Section -->
    <section class="row mb-4">
        <div class="col-12">
            <div class="filter-section">
                <form method="GET" action="{{ route('announcements.index') }}" class="filter-form">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="filter-group">
                                <label for="search" class="filter-label">
                                    <i class="fas fa-search"></i> Cari Pengumuman
                                </label>
                                <input type="text" 
                                       class="form-control filter-input" 
                                       id="search" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Cari berdasarkan judul...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="filter-group">
                                <label for="category" class="filter-label">
                                    <i class="fas fa-tags"></i> Kategori
                                </label>
                                <select class="form-select filter-select" id="category" name="category">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $key => $label)
                                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="filter-group">
                                <label for="priority" class="filter-label">
                                    <i class="fas fa-exclamation-circle"></i> Prioritas
                                </label>
                                <select class="form-select filter-select" id="priority" name="priority">
                                    <option value="">Semua Prioritas</option>
                                    @foreach($priorities as $key => $label)
                                        <option value="{{ $key }}" {{ request('priority') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="filter-group">
                                <label class="filter-label">&nbsp;</label>
                                <div class="filter-actions">
                                    <button type="submit" class="btn btn-primary filter-btn">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                    <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary filter-btn">
                                        <i class="fas fa-times"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Results Info -->
    @if(request()->hasAny(['search', 'category', 'priority']))
    <section class="row mb-3">
        <div class="col-12">
            <div class="results-info">
                <p class="results-text">
                    <i class="fas fa-info-circle"></i>
                    Menampilkan {{ $announcements->count() }} dari {{ $announcements->total() }} pengumuman
                    @if(request('search'))
                        untuk pencarian "<strong>{{ request('search') }}</strong>"
                    @endif
                    @if(request('category'))
                        dengan kategori <strong>{{ $categories[request('category')] ?? ucfirst(request('category')) }}</strong>
                    @endif
                    @if(request('priority'))
                        dengan prioritas <strong>{{ $priorities[request('priority')] ?? ucfirst(request('priority')) }}</strong>
                    @endif
                </p>
            </div>
        </div>
    </section>
    @endif

    <!-- Announcements List -->
    <section class="row" aria-label="Daftar Pengumuman">
        @forelse($announcements as $announcement)
        <article class="col-12 mb-4">
            <div class="card announcement-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="announcement-meta mb-2">
                                <span class="badge bg-{{ $announcement->priority_color }} me-2" aria-label="Prioritas: {{ $announcement->priority_label }}">
                                    {{ $announcement->priority_label }}
                                </span>
                                <span class="badge bg-secondary me-2" aria-label="Kategori: {{ $announcement->category_label }}">{{ $announcement->category_label }}</span>
                                <time class="text-muted" datetime="{{ $announcement->published_at->format('Y-m-d\TH:i') }}">
                                    <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                                    {{ $announcement->published_at->format('d M Y, H:i') }}
                                </time>
                            </div>
                            
                            <h2 class="announcement-title">
                                <a href="{{ route('announcements.show', $announcement->slug) }}" class="text-decoration-none">
                                    {{ $announcement->title }}
                                </a>
                            </h2>
                            
                            <p class="announcement-summary">{{ $announcement->summary }}</p>
                            
                            <div class="announcement-stats">
                                <small class="text-muted">
                                    <i class="fas fa-eye" aria-hidden="true"></i> {{ $announcement->views }} kali dilihat
                                </small>
                            </div>
                        </div>
                        
                        <div class="col-md-4 text-end">
                            <div class="announcement-actions">
                                <a href="{{ route('announcements.show', $announcement->slug) }}" class="btn btn-primary" aria-label="Baca detail pengumuman: {{ $announcement->title }}">
                                    <i class="fas fa-eye" aria-hidden="true"></i> Lihat Detail
                                </a>
                                
                                @if($announcement->attachment)
                                <a href="{{ $announcement->attachment }}" target="_blank" class="btn btn-outline-success mt-2 d-block" rel="noopener noreferrer" aria-label="Download lampiran pengumuman">
                                    <i class="fas fa-download" aria-hidden="true"></i> Download Lampiran
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-bullhorn fa-3x text-muted mb-3" aria-hidden="true"></i>
                <h2 class="text-muted">Belum ada pengumuman</h2>
                <p class="text-muted">Pengumuman akan muncul di sini ketika tersedia.</p>
            </div>
        </div>
        @endforelse
    </section>

    <!-- Pagination -->
    @if($announcements->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="pagination-wrapper">
                <nav aria-label="Pengumuman navigation">
                    <ul class="pagination justify-content-center">
                        <!-- Previous Page -->
                        @if($announcements->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i> Sebelumnya
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $announcements->appends(request()->query())->previousPageUrl() }}">
                                    <i class="fas fa-chevron-left"></i> Sebelumnya
                                </a>
                            </li>
                        @endif
                        
                        <!-- Page Numbers -->
                        @foreach($announcements->getUrlRange(1, $announcements->lastPage()) as $page => $url)
                            @if($page == $announcements->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $announcements->appends(request()->query())->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                        
                        <!-- Next Page -->
                        @if($announcements->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $announcements->appends(request()->query())->nextPageUrl() }}">
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
</main>
@endsection

@push('styles')
<style>
.page-title {
    color: #03aca5;
    font-weight: 800;
    text-align: center;
    margin-bottom: 1rem;
    position: relative;
    font-size: 2.5rem;
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

.filter-form {
    margin: 0;
}

.filter-group {
    margin-bottom: 0;
}

.filter-label {
    color: #03aca5;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-input,
.filter-select {
    border: 2px solid rgba(3, 172, 165, 0.2);
    border-radius: 15px;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.filter-input:focus,
.filter-select:focus {
    border-color: #03aca5;
    box-shadow: 0 0 0 0.2rem rgba(3, 172, 165, 0.25);
}

.filter-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-btn {
    padding: 0.75rem 1rem;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

/* Results Info Styling */
.results-info {
    background: rgba(3, 172, 165, 0.1);
    border-radius: 15px;
    padding: 1rem 1.5rem;
    border-left: 4px solid #03aca5;
}

.results-text {
    color: #333;
    font-size: 0.9rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.results-text i {
    color: #03aca5;
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

.announcement-card {
    border: 1px solid #e9ecef;
    border-radius: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.announcement-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.announcement-title {
    font-size: 1.4rem;
    font-weight: 600;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.announcement-title a {
    color: #333;
    transition: color 0.3s ease;
}

.announcement-title a:hover {
    color: #007bff;
}

.announcement-summary {
    color: #666;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.announcement-meta .badge {
    font-size: 0.75rem;
    padding: 0.4rem 0.8rem;
}

.announcement-stats {
    margin-top: 1rem;
}

.announcement-actions .btn {
    border-radius: 25px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
}

/* Page Header Styling - Same as Contact, Gallery, and Articles */
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

@media (max-width: 768px) {
    .filter-section {
        padding: 1.5rem;
    }
    
    .filter-actions {
        flex-direction: row;
        justify-content: center;
    }
    
    .filter-btn {
        flex: 1;
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
    
    .page-title {
        font-size: 2rem;
    }
    
    .announcement-title {
        font-size: 1.2rem;
    }
    
    .announcement-actions {
        text-align: left !important;
        margin-top: 1rem;
    }
    
    .announcement-actions .btn {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .page-title {
        font-size: 1.75rem;
    }
}
</style>
@endpush
