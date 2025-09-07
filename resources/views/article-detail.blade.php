@extends('layouts.app')

@section('title', $article['title'] . ' - SMPIT Al-Itqon')

@push('styles')
    @vite('resources/css/article-detail.css')
@endpush

@section('content')

<div class="container mt-4">
    <div class="row">
        <!-- Main Content - col-8 -->
        <div class="col-lg-8">
            <!-- Article Image -->
            <div class="article-image">
                <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="img-fluid rounded">
            </div>
            
            <!-- Excerpt Section Card (akan tertindih oleh article-content-card) -->
            <article class="article-excerpt-card article-content-card" itemscope itemtype="https://schema.org/Article">
                
                <!-- Categories -->
                <div class="entry-taxonomies">
                    <span class="category-links term-links category-style-normal">
                        @foreach($article['categories'] as $index => $category)
                            <a href="{{ route('category.show', $category->slug) }}" rel="tag" @if($index === 0) itemprop="articleSection" @endif>{{ $category->name }}</a>
                            @if($index < $article['categories']->count() - 1) | @endif
                        @endforeach
                    </span>
                </div>
                
                <!-- Article Title -->
                <h1 class="entry-title" itemprop="headline">{{ $article['title'] }}</h1>
                
                <!-- Excerpt Text -->
                <div class="excerpt-text">
                    <p><strong>{{ config('app.name') }} –</strong> {{ $article['excerpt'] }}</p>
                </div>
                
                
                
                <div class="entry-content single-content" itemprop="articleBody">
                    {!! $article['description'] !!}
                </div>

                <!-- Meta Info -->
                <div class="entry-meta entry-meta-divider-dash">
                    <span class="posted-by">
                        <span class="meta-label">By</span>
                        <span class="author vcard" itemprop="author" itemscope itemtype="https://schema.org/Person">
                            <a class="url fn n" href="{{ route('author.show', Str::slug($article['author'])) }}" itemprop="url"><span itemprop="name">{{ $article['author'] }}</span></a>
                        </span>
                    </span>
                    <span class="posted-on">
                        <time class="entry-date published" datetime="2025-08-15T18:31:12+07:00" itemprop="datePublished">{{ $article['date'] }}</time>
                    </span>
                </div>

                <div class="post-views content-post post-{{ $article['id'] }} entry-meta load-static">
                    <span class="post-views-icon">
                        <i class="bi bi-eye-fill"></i>
                    </span> 
                    <span class="post-views-count">{{ rand(20, 100) }}</span>
                </div>
                
                <!-- Share Buttons -->
                <div class="share-buttons">
                    <button type="button" class="btn btn-outline-primary btn-sm me-2" id="copyBtn" onclick="copyLink()">
                        <i class="bi bi-link-45deg"></i> <span class="btn-text">Copy Link</span>
                    </button>
                    <a href="#" class="btn btn-success btn-sm me-2" onclick="shareWhatsApp('personal')">
                        <i class="bi bi-whatsapp"></i> Share WhatsApp (Personal)
                    </a>
                    <a href="#" class="btn btn-success btn-sm" onclick="shareWhatsApp('group')">
                        <i class="bi bi-whatsapp"></i> Share WhatsApp (Group)
                    </a>
                </div>
                
                <!-- Microdata helpers -->
                <meta itemprop="mainEntityOfPage" content="{{ request()->url() }}">
                <meta itemprop="image" content="{{ $article['image'] }}">
                <div class="visually-hidden" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                    <meta itemprop="name" content="{{ config('app.name') }}">
                    <meta itemprop="url" content="{{ url('/') }}">
                </div>
            </article>


            <!-- Navigation -->
            <nav class="navigation post-navigation" aria-label="Pos">
                <h2 class="screen-reader-text">Navigasi pos</h2>
                <div class="nav-links">
                    @php
                        $previousArticle = \App\Models\Article::published()->where('id', '<', $article['id'])->latest('id')->first();
                        $nextArticle = \App\Models\Article::published()->where('id', '>', $article['id'])->oldest('id')->first();
                    @endphp
                    
                    @if($previousArticle)
                    <div class="nav-previous">
                        <a href="{{ route('article.detail', $previousArticle->slug) }}" rel="prev">
                            <div class="post-navigation-sub">
                                <small>Previous</small>
                            </div>
                            {{ $previousArticle->title }}
                        </a>
                    </div>
                    @endif
                    
                    @if($nextArticle)
                    <div class="nav-next">
                        <a href="{{ route('article.detail', $nextArticle->slug) }}" rel="next">
                            <div class="post-navigation-sub">
                                <small>Next</small>
                            </div>
                            {{ $nextArticle->title }}
                        </a>
                    </div>
                    @endif
                </div>
            </nav>
        </div>

        <!-- Sidebar - col-4 -->
        <div class="col-lg-4">
            <div class="sidebar">
                <h3 class="sidebar-title">Pos Terbaru</h3>
                
                @foreach($recentPosts as $recentPost)
                <article class="recent-post">
                    <a class="post-thumbnail" href="{{ route('article.detail', Str::slug($recentPost['title'])) }}">
                        <img width="300" height="200" src="{{ $recentPost['image'] }}" class="attachment-medium_large size-medium_large wp-post-image" alt="{{ $recentPost['title'] }}" decoding="async">
                    </a>
                    
                    <div class="post-content">
                        <div class="entry-taxonomies">
                            <span class="category-links term-links category-style-normal">
                                @foreach($recentPost['categories'] as $index => $category)
                                    <a href="{{ route('category.show', $category->slug) }}" class="category-link-{{ strtolower($category->name) }}" rel="tag">{{ $category->name }}</a>
                                    @if($index < $recentPost['categories']->count() - 1) | @endif
                                @endforeach
                            </span>
                        </div>
                        
                        <h4 class="post-title">
                            <a href="{{ route('article.detail', Str::slug($recentPost['title'])) }}" rel="bookmark">{{ $recentPost['title'] }}</a>
                        </h4>
                        
                        <div class="entry-meta entry-meta-divider-dot">
                            <span class="posted-by">
                                <span class="meta-label">By</span>
                                <span class="author vcard">
                                    <a class="url fn n" href="{{ route('author.show', Str::slug($recentPost['author'])) }}">{{ $recentPost['author'] }}</a>
                                </span>
                            </span>
                            <span class="posted-on">
                                <time class="entry-date published" datetime="2025-08-15T18:31:12+07:00" itemprop="datePublished">{{ $recentPost['date'] }}</time>
                            </span>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Share JavaScript -->
<script>
function copyLink() {
    const shareText = `[{{ $article['title'] }}/{{ $article['categories']->pluck('name')->implode(', ') }}] Archives - {{ config('app.name') }} {{ $article['shortlink'] }}`;
    
    // Check if clipboard API is available
    if (navigator.clipboard && window.isSecureContext) {
        // Modern browsers with secure context
        navigator.clipboard.writeText(shareText).then(function() {
            showCopySuccess();
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
            fallbackCopyText(shareText);
        });
    } else {
        // Fallback for older browsers or non-secure context
        fallbackCopyText(shareText);
    }
}

function fallbackCopyText(text) {
    // Create a temporary textarea element
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    textArea.style.top = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        const successful = document.execCommand('copy');
        if (successful) {
            showCopySuccess();
        } else {
            alert('Gagal menyalin link. Silakan salin manual: ' + text);
        }
    } catch (err) {
        console.error('Fallback copy failed: ', err);
        alert('Gagal menyalin link. Silakan salin manual: ' + text);
    }
    
    document.body.removeChild(textArea);
}

function showCopySuccess() {
    // Show success animation
    const button = document.getElementById('copyBtn');
    const btnText = button.querySelector('.btn-text');
    const btnIcon = button.querySelector('i');
    
    // Store original content
    const originalText = btnText.textContent;
    const originalIcon = btnIcon.className;
    
    // Change to success state
    btnText.textContent = 'Sudah Tercopy!';
    btnIcon.className = 'bi bi-check-circle-fill';
    button.classList.remove('btn-outline-primary');
    button.classList.add('btn-success');
    
    // Add pulse animation
    button.style.animation = 'pulse 0.6s ease-in-out';
    
    // Reset after 2 seconds
    setTimeout(() => {
        btnText.textContent = originalText;
        btnIcon.className = originalIcon;
        button.classList.remove('btn-success');
        button.classList.add('btn-outline-primary');
        button.style.animation = '';
    }, 2000);
}

function shareWhatsApp(type) {
    const shareText = `[{{ $article['title'] }}/{{ $article['categories']->pluck('name')->implode(', ') }}] Archives - {{ config('app.name') }} {{ $article['shortlink'] }}`;
    const encodedText = encodeURIComponent(shareText);
    const whatsappUrl = `https://api.whatsapp.com/send?text=${encodedText}`;
    
    window.open(whatsappUrl, '_blank');
}
</script>
@endsection
