@php
    $hasSlides = isset($sliders) && $sliders->count() > 0;
@endphp

@if($hasSlides)
<div id="heroBannerCarousel" class="carousel slide hero-banner-carousel" data-bs-ride="carousel" data-bs-interval="4000" data-bs-pause="hover">
    <div class="carousel-inner">
        @foreach($sliders as $index => $slider)
        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
            @php
                $img = $slider->image_url;
                $alt = $slider->title ?? 'Slide';
                $link = $slider->link ?? null;
            @endphp
            @if($link)
                <a href="{{ $link }}" target="_blank" rel="noopener noreferrer">
                    <img src="{{ $img }}" class="d-block w-100 hero-banner-img" alt="{{ $alt }}">
                </a>
            @else
                <img src="{{ $img }}" class="d-block w-100 hero-banner-img" alt="{{ $alt }}">
            @endif
        </div>
        @endforeach
    </div>

    @if($sliders->count() > 1)
    <button class="carousel-control-prev" type="button" data-bs-target="#heroBannerCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroBannerCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    @endif
</div>
@else
<div class="hero-banner position-relative hero-banner-fallback">
    <img src="https://picsum.photos/1200/500?random=10" alt="Hero Banner" class="d-block w-100 hero-banner-img">
</div>
@endif
