@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<section class="error-hero py-5" style="min-height: 78vh; display: flex; align-items: center;">
    <div class="container position-relative">
        <span class="shape shape-1"></span>
        <span class="shape shape-2"></span>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0 align-items-stretch">
                        <div class="col-12 col-md-6 p-5 p-lg-6 text-center bg-white d-flex flex-column justify-content-center">
                            <span class="badge rounded-pill bg-primary-subtle text-primary mb-3 px-3 py-2">Kesalahan 404</span>
                            <div class="display-code mb-1">404</div>
                            <h2 class="h4 fw-semibold mb-3">Halaman Tidak Ditemukan</h2>
                            <p class="text-muted mb-4">Halaman yang Anda cari tidak ditemukan atau mungkin telah dipindahkan.</p>
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                <a href="{{ route('home') }}" class="btn btn-primary"><i class="bi bi-house-door"></i> Kembali ke Beranda</a>
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Halaman Sebelumnya</a>
                                <a href="{{ route('contact') }}" class="btn btn-outline-primary"><i class="bi bi-envelope"></i> Kontak</a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 error-aside text-white p-5 d-none d-md-block">
                            <div class="h-100 d-flex flex-column justify-content-center">
                                <h3 class="fw-semibold mb-3"><i class="bi bi-lightbulb"></i> Tips</h3>
                                <p class="mb-4 opacity-90">Gunakan menu navigasi untuk menjelajah konten atau kembali ke beranda.</p>
                                <ul class="list-unstyled small mb-0 opacity-75">
                                    <li class="mb-2"><i class="bi bi-check2"></i> Periksa kembali URL yang dimasukkan.</li>
                                    <li class="mb-2"><i class="bi bi-check2"></i> Coba akses kategori dari menu utama.</li>
                                    <li class="mb-0"><i class="bi bi-check2"></i> Laporkan tautan rusak melalui kontak.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .error-hero { background: linear-gradient(135deg, #f8fbff 0%, #eef6ff 100%); position: relative; overflow: hidden; }
    .error-hero .shape { position: absolute; border-radius: 50%; filter: blur(40px); opacity: .6; }
    .error-hero .shape-1 { width: 260px; height: 260px; background: #cfe5ff; top: -40px; left: -40px; }
    .error-hero .shape-2 { width: 220px; height: 220px; background: #e8f0ff; bottom: -30px; right: -30px; }
    .display-code { font-size: 4.5rem; font-weight: 800; background: linear-gradient(90deg, #0d6efd, #6ea8fe); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .error-aside { background: linear-gradient(135deg, #0d6efd 0%, #3f8bff 100%); }
    @media (min-width: 992px) { .display-code { font-size: 6rem; } }
</style>
@endpush


