@php
    $hasSlides = isset($sliders) && $sliders->count() > 0;
@endphp

@if($hasSlides)
<div id="heroBannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000" data-bs-pause="hover" style="height: 530px; overflow: hidden;">
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
                    <img src="{{ $img }}" class="d-block w-100" alt="{{ $alt }}" style="height: 530px; object-fit: cover; object-position: center;">
                </a>
            @else
                <img src="{{ $img }}" class="d-block w-100" alt="{{ $alt }}" style="height: 530px; object-fit: cover; object-position: center;">
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
<div class="hero-banner position-relative" style="height: 530px; overflow: hidden;">
    <img src="https://picsum.photos/1200/500?random=10" alt="Hero Banner" class="d-block w-100" style="height: 530px; object-fit: cover; object-position: center;">
</div>
@endif
