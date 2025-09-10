@extends('layouts.app')

@section('title', $announcement->title . ' - Pengumuman')
@section('description', $announcement->summary)

@push('styles')
    <!-- Open Graph Meta Tags for Announcement -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $announcement->title }} - Pengumuman">
    <meta property="og:description" content="{{ $announcement->summary }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:locale" content="id_ID">
    <meta property="article:author" content="SMPIT Al-Itqon">
    <meta property="article:published_time" content="{{ $announcement->published_at->toISOString() }}">
    <meta property="article:section" content="Pengumuman">
    @if($announcement->category)
        <meta property="article:tag" content="{{ $announcement->category->name }}">
    @endif
    
    <!-- Twitter Card Meta Tags for Announcement -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $announcement->title }} - Pengumuman">
    <meta name="twitter:description" content="{{ $announcement->summary }}">
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
                    <a href="{{ route('announcements.index') }}">
                        <i class="fas fa-bullhorn"></i> Pengumuman
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-file-alt"></i> {{ Str::limit($announcement->title, 50) }}
                </li>
            </ol>
        </div>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="announcement-detail">
                <!-- Header -->
                <div class="announcement-header mb-4">
                    <div class="announcement-meta mb-3">
                        <span class="badge bg-{{ $announcement->priority_color }} me-2">
                            {{ $announcement->priority_label }}
                        </span>
                        <span class="badge bg-secondary me-2">{{ $announcement->category_label }}</span>
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $announcement->published_at->format('d M Y, H:i') }}
                        </small>
                    </div>
                    
                    <h1 class="announcement-title">{{ $announcement->title }}</h1>
                    
                    <div class="announcement-stats">
                        <small class="text-muted">
                            <i class="fas fa-eye"></i> {{ $announcement->views }} kali dilihat
                        </small>
                    </div>
                </div>

                <!-- Summary -->
                <div class="announcement-summary mb-4">
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle"></i> Ringkasan</h5>
                        <p class="mb-0">{{ $announcement->summary }}</p>
                    </div>
                </div>

                <!-- Content -->
                <div class="announcement-content">
                    <div class="content-body">
                        {!! nl2br(e($announcement->content)) !!}
                    </div>
                </div>

                <!-- Attachments -->
                @php
                    $hasMultiple = isset($announcement->attachments) && $announcement->attachments->count() > 0;
                @endphp
                @if($hasMultiple || $announcement->attachment)
                <div class="announcement-attachment mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-paperclip"></i> Lampiran</h5>
                        </div>
                        <div class="card-body">
                            @if($hasMultiple)
                                <div class="list-group">
                                    @foreach($announcement->attachments as $att)
                                    <div class="list-group-item d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="attachment-icon me-3">
                                                <i class="fas fa-file-alt fa-2x text-secondary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $att->file_name ?? basename($att->file_url) }}</h6>
                                                @if($att->file_type)
                                                <small class="text-muted">{{ strtoupper($att->file_type) }} @if($att->file_size) • {{ number_format($att->file_size / 1024, 1) }} KB @endif</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{ $att->file_url }}" target="_blank" class="btn btn-primary">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="d-flex align-items-center">
                                    <div class="attachment-icon me-3">
                                        <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                    </div>
                                    <div class="attachment-info flex-grow-1">
                                        <h6 class="mb-1">{{ $announcement->attachment_name }}</h6>
                                        <small class="text-muted">File lampiran</small>
                                    </div>
                                    <div class="attachment-actions">
                                        <a href="{{ $announcement->attachment }}" target="_blank" class="btn btn-primary">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="announcement-actions mt-4">
                    <a href="{{ route('announcements.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                    
                    <div class="float-end">
                        <a href="https://wa.me/?text={{ urlencode($announcement->title . ' - ' . ($shortlinkUrl ?? route('announcements.show', $announcement->slug))) }}" target="_blank" rel="noopener" class="btn btn-success">
                            <i class="fab fa-whatsapp"></i> Bagikan via WhatsApp
                        </a>
                    </div>
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related Announcements -->
            @if($relatedAnnouncements->count() > 0)
            <div class="sidebar-widget">
                <h4 class="widget-title">Pengumuman Terkait</h4>
                <div class="related-announcements">
                    @foreach($relatedAnnouncements as $related)
                    <div class="related-item">
                        <h6>
                            <a href="{{ route('announcements.show', $related->slug) }}" class="text-decoration-none">
                                {{ $related->title }}
                            </a>
                        </h6>
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $related->published_at->format('d M Y') }}
                        </small>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Quick Links -->
            <div class="sidebar-widget">
                <h4 class="widget-title">Menu Cepat</h4>
                <div class="quick-links">
                    <a href="{{ route('announcements.index') }}" class="quick-link">
                        <i class="fas fa-list"></i> Semua Pengumuman
                    </a>
                    @if($announcement->category)
                    <a href="{{ route('announcements.index', ['category' => $announcement->category->slug]) }}" class="quick-link">
                        <i class="fas fa-tag"></i> {{ $announcement->category->name }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.announcement-detail {
    background: #ffffff;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.announcement-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #333;
    line-height: 1.3;
    margin-bottom: 1rem;
}

.announcement-meta .badge {
    font-size: 0.8rem;
    padding: 0.5rem 1rem;
}

.announcement-summary .alert {
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
}

.announcement-content {
    line-height: 1.8;
    color: #333;
}

.content-body {
    font-size: 1.1rem;
}

.announcement-attachment .card {
    border-radius: 10px;
    border: 1px solid #e9ecef;
}

/* Make attachment list mobile friendly */
.announcement-attachment .list-group-item {
    gap: 0.75rem;
}

.announcement-attachment .list-group-item h6 {
    word-break: break-word;
}

.attachment-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 8px;
}

.announcement-actions {
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
    border-bottom: 2px solid #007bff;
}

.related-item {
    padding: 1rem 0;
    border-bottom: 1px solid #e9ecef;
}

.related-item:last-child {
    border-bottom: none;
}

.related-item h6 {
    margin-bottom: 0.5rem;
}

.related-item a {
    color: #333;
    transition: color 0.3s ease;
}

.related-item a:hover {
    color: #007bff;
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
    background: #007bff;
    color: #ffffff;
    text-decoration: none;
    transform: translateX(5px);
}

@media (max-width: 768px) {
    .announcement-detail {
        padding: 1.5rem;
    }
    
    .announcement-title {
        font-size: 1.8rem;
    }
    
    .announcement-actions {
        text-align: center;
    }
    
    .announcement-actions .float-end {
        float: none !important;
        margin-top: 1rem;
    }

    /* Stack attachment list on mobile */
    .announcement-attachment .list-group-item {
        flex-direction: column;
        align-items: stretch !important;
    }

    .announcement-attachment .list-group-item > div:last-child {
        margin-top: 0.5rem;
    }

    .announcement-attachment .btn {
        width: 100%;
    }
}
</style>
@endpush
