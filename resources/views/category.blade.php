@extends('layouts.app')

@section('title', 'Kategori: ' . $categoryName . ' - Portal Islam')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="category-header mb-4">
                <h1 class="category-title">Kategori: {{ $categoryName }}</h1>
                <p class="category-description">Artikel-artikel dalam kategori {{ $categoryName }}</p>
            </div>
            
            <div class="row">
                @foreach($articles as $article)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ $article->image }}" class="card-img-top" alt="{{ $article->title }}">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <div class="entry-taxonomies">
                                    <span class="category-links term-links category-style-normal">
                                        @foreach($article->categories as $index => $category)
                                            <a href="{{ route('category.show', $category->slug) }}" rel="tag">{{ $category->name }}</a>
                                            @if($index < $article->categories->count() - 1) | @endif
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                            <h2 class="card-title">
                                <a href="{{ route('article.detail', $article->slug) }}" class="article-title-link">{{ $article->title }}</a>
                            </h2>
                            <p class="card-text">{{ $article->excerpt }}</p>
                            <div class="entry-meta entry-meta-divider-dot mt-auto">
                                <span class="posted-by">
                                    <span class="meta-label">By</span>
                                    <span class="author vcard">
                                        <a class="url fn n" href="{{ route('author.show', $article->author->slug) }}">{{ $article->author->name }}</a>
                                    </span>
                                </span>
                                <span class="posted-on">
                                    <time class="entry-date published" datetime="{{ $article->published_at->format('Y-m-d') }}" itemprop="datePublished">{{ $article->published_at->format('d/m/Y') }}</time>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $articles->links() }}
            </div>
            
            @if($articles->isEmpty())
            <div class="text-center py-5">
                <h3>Tidak ada artikel dalam kategori ini</h3>
                <p>Silakan pilih kategori lain atau kembali ke <a href="{{ route('home') }}">halaman utama</a></p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
