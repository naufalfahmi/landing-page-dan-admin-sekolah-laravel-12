<!-- Announcements Widget -->
<div class="announcements-widget">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="widget-header">
                    <h3 class="widget-title">
                        <i class="fas fa-bullhorn"></i>
                        Pengumuman Terbaru
                    </h3>
                    <a href="{{ route('announcements.index') }}" class="view-all-btn">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="row">
            @forelse($announcements as $announcement)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="announcement-card">
                    <div class="card-header">
                        <div class="announcement-meta">
                            <span class="badge bg-{{ $announcement->priority_color }}">
                                {{ $announcement->priority_label }}
                            </span>
                            <span class="badge bg-secondary">{{ $announcement->category_label }}</span>
                        </div>
                        <small class="announcement-date">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $announcement->published_at->format('d M Y') }}
                        </small>
                    </div>
                    
                    <div class="card-body">
                        <h5 class="announcement-title">
                            <a href="{{ route('announcements.show', $announcement->slug) }}">
                                {{ Str::limit($announcement->title, 60) }}
                            </a>
                        </h5>
                        
                        <p class="announcement-summary">
                            {{ Str::limit($announcement->summary, 100) }}
                        </p>
                        
                        <div class="announcement-footer">
                            <a href="{{ route('announcements.show', $announcement->slug) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Baca Selengkapnya
                            </a>
                            
                            @if($announcement->attachment)
                            <a href="{{ $announcement->attachment }}" target="_blank" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-download"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-4">
                    <i class="fas fa-bullhorn fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0">Belum ada pengumuman terbaru</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
