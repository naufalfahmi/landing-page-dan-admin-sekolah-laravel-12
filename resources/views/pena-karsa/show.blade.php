@extends('layouts.app')

@section('title', $penaKarsa->title . ' - Pena Karsa')
@section('description', $penaKarsa->excerpt)

@push('styles')
    <!-- Open Graph Meta Tags for Pena Karsa Article -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $penaKarsa->title }} - Pena Karsa">
    <meta property="og:description" content="{{ $penaKarsa->excerpt }}">
    <meta property="og:url" content="{{ request()->url() }}">
    @if($penaKarsa->image)
        <meta property="og:image" content="{{ asset('storage/' . $penaKarsa->image) }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:type" content="image/jpeg">
    @endif
    <meta property="og:locale" content="id_ID">
    <meta property="article:author" content="{{ $penaKarsa->author_name }}">
    <meta property="article:published_time" content="{{ $penaKarsa->published_at ? $penaKarsa->published_at->toISOString() : $penaKarsa->created_at->toISOString() }}">
    <meta property="article:section" content="Pena Karsa">
    
    <!-- Twitter Card Meta Tags for Pena Karsa Article -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $penaKarsa->title }} - Pena Karsa">
    <meta name="twitter:description" content="{{ $penaKarsa->excerpt }}">
    @if($penaKarsa->image)
        <meta name="twitter:image" content="{{ asset('storage/' . $penaKarsa->image) }}">
    @endif
@endpush

@section('content')
<div class="container py-5">

    <div class="row">
        <div class="col-lg-8">
            <!-- Article Header -->
            <div class="pena-karsa-article-header mb-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="pena-karsa-type-badge type-badge type-{{ $penaKarsa->type }}">
                        {{ $penaKarsa->type_display }}
                    </span>
                    @if($penaKarsa->is_featured)
                        <span class="pena-karsa-featured ms-2">
                            <i class="fas fa-star"></i>
                        </span>
                    @endif
                </div>
                
                <h1 class="pena-karsa-article-title mb-3">{{ $penaKarsa->title }}</h1>
                
                <div class="pena-karsa-article-meta mb-4">
                    <div class="pena-karsa-author">
                        <i class="fas fa-user"></i>
                        <div class="author-info">
                            <span class="author-name">{{ $penaKarsa->author_name }}</span>
                            @if($penaKarsa->author_type === 'student' && $penaKarsa->author_class)
                                <span class="author-class">({{ $penaKarsa->author_class }})</span>
                            @elseif($penaKarsa->author_type === 'teacher' && $penaKarsa->author_position)
                                <span class="author-position">({{ $penaKarsa->author_position }})</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tags -->
                @php
                    $cleanTags = $penaKarsa->getCleanTags();
                @endphp
                @if(count($cleanTags) > 0)
                    <div class="pena-karsa-tags mb-4">
                        @foreach($cleanTags as $tag)
                            <span class="pena-karsa-tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Article Image -->
            @if($penaKarsa->image)
                <div class="pena-karsa-article-image mb-4">
                    <img src="{{ asset('storage/' . $penaKarsa->image) }}" 
                         alt="{{ $penaKarsa->title }}" 
                         class="img-fluid rounded-3 shadow-sm">
                </div>
            @endif

            <!-- Article Content -->
            <div class="pena-karsa-article-content">
                <div class="content-body">
                    {!! $penaKarsa->content !!}
                </div>
            </div>

            <!-- Article Footer -->
            <div class="pena-karsa-article-footer mt-5 pt-4 border-top">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="pena-karsa-author-info">
                            <h6 class="mb-2">Tentang Penulis</h6>
                            <div class="d-flex align-items-center">
                                <div class="author-avatar me-3">
                                    <div class="avatar-circle">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="author-name fw-bold">{{ $penaKarsa->author_name }}</div>
                                    <div class="author-type text-muted">
                                        @if($penaKarsa->author_type === 'student')
                                            Siswa {{ $penaKarsa->author_class ? 'Kelas ' . $penaKarsa->author_class : '' }}
                                        @elseif($penaKarsa->author_type === 'teacher')
                                            Guru {{ $penaKarsa->author_position ? $penaKarsa->author_position : '' }}
                                        @else
                                            Penulis Tamu
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <div class="pena-karsa-share">
                            <h6 class="mb-2">Bagikan Artikel</h6>
                            <div class="share-buttons">
                                <a href="#" class="btn btn-success btn-sm me-2" onclick="shareWhatsApp('personal')">
                                    <i class="bi bi-whatsapp"></i> Share WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="pena-karsa-sidebar">
                <!-- Related Articles -->
                <div class="pena-karsa-sidebar-widget mb-4">
                    <h5 class="pena-karsa-sidebar-title">Artikel Terkait</h5>
                    <div class="pena-karsa-sidebar-content">
                        @php
                            $relatedArticles = \App\Models\PenaKarsa::published()
                                ->where('id', '!=', $penaKarsa->id)
                                ->where('type', $penaKarsa->type)
                                ->latest('published_at')
                                ->take(3)
                                ->get();
                        @endphp
                        
                        @if($relatedArticles->count() > 0)
                            @foreach($relatedArticles as $article)
                                <div class="pena-karsa-sidebar-item mb-3">
                                    <div class="d-flex">
                                        @if($article->image)
                                            <div class="pena-karsa-sidebar-image me-3">
                                                <img src="{{ asset('storage/' . $article->image) }}" 
                                                     alt="{{ $article->title }}" 
                                                     class="img-fluid rounded">
                                            </div>
                                        @endif
                                        <div class="pena-karsa-sidebar-content">
                                            <h6 class="pena-karsa-sidebar-item-title">
                                                <a href="{{ route('pena-karsa.show', $article->slug) }}" 
                                                   class="text-decoration-none">
                                                    {{ Str::limit($article->title, 60) }}
                                                </a>
                                            </h6>
                                            <div class="pena-karsa-sidebar-meta">
                                                <small class="text-muted">
                                                    {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Belum ada artikel terkait.</p>
                        @endif
                    </div>
                </div>

                <!-- Popular Articles -->
                <div class="pena-karsa-sidebar-widget mb-4">
                    <h5 class="pena-karsa-sidebar-title">Artikel Populer</h5>
                    <div class="pena-karsa-sidebar-content">
                        @php
                            $popularArticles = \App\Models\PenaKarsa::published()
                                ->where('id', '!=', $penaKarsa->id)
                                ->orderBy('views', 'desc')
                                ->take(5)
                                ->get();
                        @endphp
                        
                        @if($popularArticles->count() > 0)
                            @foreach($popularArticles as $index => $article)
                                <div class="pena-karsa-sidebar-item mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="pena-karsa-sidebar-number me-3">
                                            <span class="badge bg-primary">{{ $index + 1 }}</span>
                                        </div>
                                        <div class="pena-karsa-sidebar-content">
                                            <h6 class="pena-karsa-sidebar-item-title mb-1">
                                                <a href="{{ route('pena-karsa.show', $article->slug) }}" 
                                                   class="text-decoration-none">
                                                    {{ Str::limit($article->title, 50) }}
                                                </a>
                                            </h6>
                                            <div class="pena-karsa-sidebar-meta">
                                                <small class="text-muted">
                                                    <i class="fas fa-eye me-1"></i>{{ number_format($article->views) }} views
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Belum ada artikel populer.</p>
                        @endif
                    </div>
                </div>

                <!-- Back to List -->
                <div class="pena-karsa-sidebar-widget">
                    <a href="{{ route('pena-karsa.index') }}" class="btn pena-karsa-btn w-100">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Pena Karsa Article Styles */
.pena-karsa-article-header {
    background: linear-gradient(135deg, #f0fdfa 0%, #e6fffa 100%);
    padding: 2rem;
    border-radius: 15px;
    border-left: 4px solid #03aca5;
}

.pena-karsa-article-title {
    color: #1F2937;
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.2;
}

.pena-karsa-article-meta {
    color: #6B7280;
}

.pena-karsa-article-meta .pena-karsa-author {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
}

.pena-karsa-article-meta .pena-karsa-author i {
    color: #03aca5;
    width: 16px;
    text-align: center;
    flex-shrink: 0;
}

.author-info {
    display: flex;
    flex-direction: column;
    gap: 0.1rem;
}

.pena-karsa-article-meta .author-name {
    font-weight: 600;
    color: #374151;
    font-size: 0.95rem;
}

.pena-karsa-article-meta .author-class,
.pena-karsa-article-meta .author-position {
    color: #6B7280;
    font-size: 0.85rem;
}

/* Desktop specific alignment */
@media (min-width: 768px) {
    .author-info {
        flex-direction: row;
        gap: 0.5rem;
        align-items: center;
    }
    
    .pena-karsa-article-meta .author-name {
        white-space: nowrap;
    }
    
    .pena-karsa-article-meta .author-class,
    .pena-karsa-article-meta .author-position {
        white-space: nowrap;
    }
}

.pena-karsa-article-image img {
    width: 100%;
    height: 400px;
    object-fit: cover;
}

.pena-karsa-article-content {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(3, 172, 165, 0.1);
}

.content-body {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #374151;
}

.content-body h1, .content-body h2, .content-body h3, 
.content-body h4, .content-body h5, .content-body h6 {
    color: #1F2937;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.content-body p {
    margin-bottom: 1.5rem;
}

.content-body img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.content-body blockquote {
    border-left: 4px solid #03aca5;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #6B7280;
}

.pena-karsa-article-footer {
    background: #f9fafb;
    padding: 2rem;
    border-radius: 15px;
}

.author-avatar .avatar-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #03aca5, #0d9488);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.pena-karsa-sidebar {
    position: sticky;
    top: 2rem;
}

.pena-karsa-sidebar-widget {
    background: white;
    padding: 1.5rem;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(3, 172, 165, 0.1);
}

.pena-karsa-sidebar-title {
    color: #03aca5;
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e5e7eb;
}

.pena-karsa-sidebar-item-title a {
    color: #374151;
    font-weight: 500;
    transition: color 0.3s ease;
}

.pena-karsa-sidebar-item-title a:hover {
    color: #03aca5;
}

.pena-karsa-sidebar-image {
    width: 60px;
    height: 60px;
    overflow: hidden;
    border-radius: 8px;
}

.pena-karsa-sidebar-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.pena-karsa-sidebar-number .badge {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.share-buttons .btn {
    margin-bottom: 0.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .pena-karsa-article-title {
        font-size: 2rem;
    }
    
    .pena-karsa-article-header {
        padding: 1.5rem;
    }
    
    .pena-karsa-article-content {
        padding: 1.5rem;
    }
    
    .pena-karsa-article-image img {
        height: 250px;
    }
    
    .content-body {
        font-size: 1rem;
    }
    
    .pena-karsa-sidebar {
        position: static;
        margin-top: 2rem;
    }
    
    .pena-karsa-article-meta .row > div {
        margin-bottom: 0.5rem;
    }
    
    .pena-karsa-article-meta .pena-karsa-author,
    .pena-karsa-article-meta .pena-karsa-meta,
    .pena-karsa-article-meta .pena-karsa-views {
        font-size: 0.9rem;
    }
}
</style>

<script>
function shareWhatsApp(type) {
    const url = window.location.href;
    const title = "{{ $penaKarsa->title }}";
    const text = `${title} - ${url}`;
    
    if (type === 'personal') {
        // Share to personal WhatsApp
        window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
    }
}
</script>
@endsection
