<footer class="bg-white border-top py-4 mt-4">
    <div class="container">
        <div class="row">
            <!-- Quick Links -->
            <div class="col-md-4 mb-3">
                <h6 class="footer-title">Menu Cepat</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('announcements.index') }}">Pengumuman</a></li>
                    <li><a href="{{ route('announcements.index', ['category' => 'akademik']) }}">Akademik</a></li>
                    <li><a href="{{ route('announcements.index', ['category' => 'kegiatan']) }}">Kegiatan</a></li>
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
                    <p class="mb-1">
                        <i class="fas fa-map-marker-alt"></i>
                        Jl. KH. Sholeh Iskandar Km.2 Kd. Badak Bogor
                    </p>
                    <p class="mb-1">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:info@admin.com">info@admin.com</a>
                    </p>
                    <p class="mb-0">
                        <i class="fab fa-whatsapp"></i>
                        <a href="https://wa.me/628151888930" target="_blank">+628151888930</a>
                    </p>
                </div>
            </div>
        </div>
        
        <hr class="my-3">
        
        <div class="row">
            <div class="col-12 text-center">
                <small class="text-muted">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</small>
            </div>
        </div>
    </div>
</footer>


