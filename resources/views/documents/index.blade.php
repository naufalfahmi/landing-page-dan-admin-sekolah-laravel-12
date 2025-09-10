@extends('layouts.app')

@section('title', 'Dokumen & Download - ' . config('app.name'))

@section('meta')
<meta name="description" content="Download dokumen resmi sekolah, surat edaran, jadwal ujian, formulir, dan pengumuman penting lainnya.">
<meta name="keywords" content="download dokumen, surat edaran, jadwal ujian, formulir sekolah, dokumen resmi">
<meta property="og:title" content="Dokumen & Download - {{ config('app.name') }}">
<meta property="og:description" content="Download dokumen resmi sekolah, surat edaran, jadwal ujian, formulir, dan pengumuman penting lainnya">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@endsection

@section('content')
<main class="container mt-4">
    <!-- Page Header -->
    <header class="row mb-4">
        <div class="col-12">
            <h1 class="page-title">Dokumen & Download</h1>
            <p class="page-subtitle">Download dokumen resmi sekolah, surat edaran, jadwal ujian, dan formulir</p>
        </div>
    </header>

    <!-- Filter Section -->
    <section class="row mb-4">
        <div class="col-12">
            <div class="filter-section">
                <form method="GET" action="{{ route('documents.index') }}" class="filter-form">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="filter-group">
                                <label for="search" class="filter-label">
                                    <i class="fas fa-search"></i> Cari Dokumen
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
                                    @foreach($categories as $category)
                                        <option value="{{ $category['value'] }}" 
                                                {{ request('category') == $category['value'] ? 'selected' : '' }}>
                                            {{ $category['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="filter-group">
                                <label for="file_type" class="filter-label">
                                    <i class="fas fa-file"></i> Tipe File
                                </label>
                                <select class="form-select filter-select" id="file_type" name="file_type">
                                    <option value="">Semua Tipe</option>
                                    @foreach($fileTypes as $fileType)
                                        <option value="{{ $fileType['value'] }}" 
                                                {{ request('file_type') == $fileType['value'] ? 'selected' : '' }}>
                                            {{ $fileType['label'] }}
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
                                    <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary filter-btn">
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
    @if(request()->hasAny(['search', 'category', 'file_type']))
    <section class="row mb-3">
        <div class="col-12">
            <div class="results-info">
                <p class="results-text">
                    <i class="fas fa-info-circle"></i>
                    Menampilkan {{ $documents->count() }} dari {{ $documents->total() }} dokumen
                    @if(request('search'))
                        untuk pencarian "<strong>{{ request('search') }}</strong>"
                    @endif
                    @if(request('category'))
                        dengan kategori <strong>{{ ucfirst(request('category')) }}</strong>
                    @endif
                    @if(request('file_type'))
                        dengan tipe file <strong>{{ collect($fileTypes)->where('value', request('file_type'))->first()['label'] ?? request('file_type') }}</strong>
                    @endif
                </p>
            </div>
        </div>
    </section>
    @endif

    <!-- Documents Grid -->
    <section class="row">
        <div class="col-12">
            <div class="documents-grid">
                @forelse($documents as $document)
                <div class="document-card" data-type="{{ $document->file_type }}">
                    <div class="document-icon">
                        @if($document->file_type === 'pdf')
                            <i class="fas fa-file-pdf"></i>
                        @elseif($document->file_type === 'doc' || $document->file_type === 'docx')
                            <i class="fas fa-file-word"></i>
                        @elseif($document->file_type === 'xls' || $document->file_type === 'xlsx')
                            <i class="fas fa-file-excel"></i>
                        @elseif($document->file_type === 'ppt' || $document->file_type === 'pptx')
                            <i class="fas fa-file-powerpoint"></i>
                        @elseif($document->file_type === 'jpg' || $document->file_type === 'jpeg' || $document->file_type === 'png')
                            <i class="fas fa-file-image"></i>
                        @else
                            <i class="fas fa-file"></i>
                        @endif
                    </div>
                    <div class="document-info">
                        <h4 class="document-title">{{ $document->title }}</h4>
                        <p class="document-description">{{ $document->description }}</p>
                        <div class="document-meta">
                            <span class="document-type">{{ $document->category_label }}</span>
                            <span class="document-size">{{ $document->file_size }}</span>
                        </div>
                        <div class="document-actions">
                            <a href="{{ $document->file_url }}" 
                               class="download-btn" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               download>
                                <i class="fas fa-download"></i>
                                Download
                            </a>
                            <a href="{{ route('announcements.show', $document->announcement_slug) }}" 
                               class="view-btn">
                                <i class="fas fa-eye"></i>
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="documents-empty">
                    <i class="fas fa-file-download fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada dokumen</h4>
                    <p class="text-muted">Dokumen akan muncul di sini ketika tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Pagination -->
    @if($documents->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="pagination-wrapper">
                <nav aria-label="Dokumen navigation">
                    <ul class="pagination justify-content-center">
                        <!-- Previous Page -->
                        @if($documents->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i> Sebelumnya
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $documents->appends(request()->query())->previousPageUrl() }}">
                                    <i class="fas fa-chevron-left"></i> Sebelumnya
                                </a>
                            </li>
                        @endif
                        
                        <!-- Page Numbers -->
                        @foreach($documents->getUrlRange(1, $documents->lastPage()) as $page => $url)
                            @if($page == $documents->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $documents->appends(request()->query())->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                        
                        <!-- Next Page -->
                        @if($documents->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $documents->appends(request()->query())->nextPageUrl() }}">
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

/* Documents Grid Styling */
.documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.document-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(3, 172, 165, 0.1);
    border: 1px solid rgba(3, 172, 165, 0.1);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.document-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #03aca5, #02d4c7);
}

.document-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 48px rgba(3, 172, 165, 0.2);
}

.document-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    position: relative;
}

.document-icon i {
    font-size: 2.5rem;
    color: #ffffff;
}

/* File type colors */
.document-card[data-type="pdf"] .document-icon {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.document-card[data-type="doc"] .document-icon,
.document-card[data-type="docx"] .document-icon {
    background: linear-gradient(135deg, #3498db, #2980b9);
}

.document-card[data-type="xls"] .document-icon,
.document-card[data-type="xlsx"] .document-icon {
    background: linear-gradient(135deg, #27ae60, #229954);
}

.document-card[data-type="ppt"] .document-icon,
.document-card[data-type="pptx"] .document-icon {
    background: linear-gradient(135deg, #e67e22, #d35400);
}

.document-card[data-type="jpg"] .document-icon,
.document-card[data-type="jpeg"] .document-icon,
.document-card[data-type="png"] .document-icon {
    background: linear-gradient(135deg, #9b59b6, #8e44ad);
}

.document-card[data-type="default"] .document-icon {
    background: linear-gradient(135deg, #03aca5, #028a85);
}

.document-info {
    text-align: center;
}

.document-title {
    color: #333;
    font-weight: 700;
    font-size: 1.2rem;
    margin-bottom: 0.75rem;
    line-height: 1.3;
}

.document-description {
    color: #666;
    font-size: 0.95rem;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.document-meta {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.document-type {
    background: rgba(3, 172, 165, 0.1);
    color: #03aca5;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.document-size {
    background: rgba(102, 102, 102, 0.1);
    color: #666;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.document-actions {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
}

.download-btn,
.view-btn {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.8rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.download-btn {
    background: linear-gradient(135deg, #03aca5, #028a85);
    color: #ffffff;
    border: none;
}

.download-btn:hover {
    background: linear-gradient(135deg, #028a85, #026b67);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(3, 172, 165, 0.3);
}

.view-btn {
    background: transparent;
    color: #03aca5;
    border: 2px solid #03aca5;
}

.view-btn:hover {
    background: #03aca5;
    color: #ffffff;
    transform: translateY(-2px);
}

.documents-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem 1rem;
}

/* Responsive Design */
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
    
    .documents-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    
    .document-card {
        padding: 1.5rem;
    }
    
    .document-icon {
        width: 60px;
        height: 60px;
    }
    
    .document-icon i {
        font-size: 2rem;
    }
    
    .document-actions {
        flex-direction: column;
    }
    
    .download-btn,
    .view-btn {
        width: 100%;
        justify-content: center;
    }
    
    .page-title {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .documents-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .document-card {
        padding: 1.25rem;
    }
    
    .document-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .page-title {
        font-size: 1.75rem;
    }
}
</style>
@endpush
