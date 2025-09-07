<!-- Hero Slider Component -->
@if($sliders->count() > 0)
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="hover">
    <!-- Carousel Inner -->
    <div class="carousel-inner">
        @foreach($sliders as $index => $slider)
        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
            <div class="hero-slide">
                @if($slider->link)
                    <a href="{{ $slider->link }}" target="_blank" rel="noopener noreferrer">
                        <img src="{{ $slider->image }}" class="d-block w-100" alt="{{ $slider->title }}">
                    </a>
                @else
                    <img src="{{ $slider->image }}" class="d-block w-100" alt="{{ $slider->title }}">
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Navigation Arrows -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
@else
<!-- Default slider jika tidak ada data -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="hover">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="hero-slide">
                <img src="https://picsum.photos/1200/500?random=1" class="d-block w-100" alt="Default Slide 1">
            </div>
        </div>
    </div>
</div>
@endif

