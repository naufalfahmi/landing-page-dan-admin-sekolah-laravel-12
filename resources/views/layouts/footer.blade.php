<footer class="bg-white border-top py-4 mt-4">
    <div class="container">
        <div class="row">
            <!-- Quick Links -->
            <div class="col-md-4 mb-3">
                <h6 class="footer-title">Menu Cepat</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('announcements.index') }}">Pengumuman</a></li>
                    <li><a href="{{ route('galleries.index') }}">Galeri</a></li>
                    <li><a href="{{ route('articles.index') }}">Berita</a></li>
                </ul>
            </div>
            
            <!-- Announcement Categories -->
            <div class="col-md-4 mb-3">
                <h6 class="footer-title">Kategori Pengumuman</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('announcements.index', ['category' => 'ujian']) }}">Ujian</a></li>
                    <li><a href="{{ route('announcements.index', ['category' => 'libur']) }}">Libur</a></li>
                    <li><a href="{{ route('announcements.index', ['category' => 'umum']) }}">Umum</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div class="col-md-4 mb-3">
                <h6 class="footer-title">Kontak</h6>
                <div class="footer-contact">
                    @php
                        $contactAddress = \App\Models\Setting::getValue('contact_address', 'Jl. KH. Sholeh Iskandar Km.2 Kd. Badak Bogor');
                        $contactEmail = \App\Models\Setting::getValue('contact_email', 'info@admin.com');
                        $contactWhatsapp = \App\Models\Setting::getValue('contact_whatsapp', '628151888930');
                        $siteTitle = \App\Models\Setting::getValue('site_title', config('app.name', 'SMPIT Al-Itqon'));
                    @endphp
                    <p class="mb-1">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $contactAddress }}
                    </p>
                    <p class="mb-1">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                    </p>
                    <p class="mb-0">
                        <i class="fab fa-whatsapp"></i>
                        <a href="https://wa.me/{{ $contactWhatsapp }}" target="_blank">{{ $contactWhatsapp }}</a>
                    </p>
                </div>
            </div>
        </div>
        
        <hr class="my-3">
        
        <div class="row">
            <div class="col-12 text-center">
                <small class="text-muted">&copy; {{ date('Y') }} {{ $siteTitle }}. All rights reserved.</small>
            </div>
        </div>
    </div>
</footer>


