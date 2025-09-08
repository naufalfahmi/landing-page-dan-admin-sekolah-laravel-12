<!-- Gallery Widget -->
<div class="gallery-widget">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="widget-header">
                    <h3 class="widget-title">
                        <i class="fas fa-images"></i>
                        Galeri Foto
                    </h3>
                    <a href="{{ route('galleries.index') }}" class="view-all-btn">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        
        <!-- Photo Grid - Same as Galleries Page -->
        <div class="photo-grid-widget">
            @forelse($galleries as $gallery)
            <div class="photo-item-widget" data-category="{{ $gallery->category ? $gallery->category->slug : '' }}">
                <div class="photo-container-widget">
                    <a href="{{ $gallery->image }}" 
                       id="gallery-widget-{{ $gallery->id }}"
                       class="glightbox" 
                       data-gallery="gallery-widget"
                       data-title="{{ $gallery->title }}"
                       data-description="{{ $gallery->description }}"
                       data-type="image">
                        <img src="{{ $gallery->thumbnail ?? $gallery->image }}" 
                             alt="{{ $gallery->title }}" 
                             loading="lazy"
                             class="photo-image-widget">
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
    </div>
</div>

