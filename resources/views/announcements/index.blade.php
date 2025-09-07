@extends('layouts.app')

@section('title', 'Pengumuman - ' . config('app.name'))

@section('content')
<div class="container mt-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="page-title">Pengumuman</h1>
            <p class="page-subtitle">Informasi terbaru dan pengumuman penting dari sekolah</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('announcements.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="category" class="form-label">Kategori</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="priority" class="form-label">Prioritas</label>
                            <select name="priority" id="priority" class="form-select">
                                <option value="">Semua Prioritas</option>
                                @foreach($priorities as $key => $label)
                                    <option value="{{ $key }}" {{ request('priority') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements List -->
    <div class="row">
        @forelse($announcements as $announcement)
        <div class="col-12 mb-4">
            <div class="card announcement-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="announcement-meta mb-2">
                                <span class="badge bg-{{ $announcement->priority_color }} me-2">
                                    {{ $announcement->priority_label }}
                                </span>
                                <span class="badge bg-secondary me-2">{{ $announcement->category_label }}</span>
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $announcement->published_at->format('d M Y, H:i') }}
                                </small>
                            </div>
                            
                            <h3 class="announcement-title">
                                <a href="{{ route('announcements.show', $announcement->slug) }}" class="text-decoration-none">
                                    {{ $announcement->title }}
                                </a>
                            </h3>
                            
                            <p class="announcement-summary">{{ $announcement->summary }}</p>
                            
                            <div class="announcement-stats">
                                <small class="text-muted">
                                    <i class="fas fa-eye"></i> {{ $announcement->views }} kali dilihat
                                </small>
                            </div>
                        </div>
                        
                        <div class="col-md-4 text-end">
                            <div class="announcement-actions">
                                <a href="{{ route('announcements.show', $announcement->slug) }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                                
                                @if($announcement->attachment)
                                <a href="{{ $announcement->attachment }}" target="_blank" class="btn btn-outline-success mt-2 d-block">
                                    <i class="fas fa-download"></i> Download Lampiran
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada pengumuman</h4>
                <p class="text-muted">Pengumuman akan muncul di sini ketika tersedia.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($announcements->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center mt-4">
                {{ $announcements->links() }}
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

@media (max-width: 768px) {
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
</style>
@endpush
