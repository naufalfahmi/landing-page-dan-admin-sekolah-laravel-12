<!-- Documents Widget -->
<div class="documents-widget">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="widget-header">
                    <h3 class="widget-title">
                        <i class="fas fa-download"></i>
                        Dokumen & Download
                    </h3>
                    <a href="{{ route('documents.index') }}" class="view-all-btn">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="row">
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
                                    Lihat Detail
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
        </div>
    </div>
</div>
