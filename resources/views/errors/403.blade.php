@extends('layouts.app')

@section('title', '403 - Akses Ditolak')

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
                            <span class="badge rounded-pill bg-danger-subtle text-danger mb-3 px-3 py-2">Kesalahan 403</span>
                            <div class="display-code mb-1 text-danger-gradient">403</div>
                            <h2 class="h4 fw-semibold mb-3">Akses Ditolak</h2>
                            <p class="text-muted mb-4">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                <a href="{{ route('home') }}" class="btn btn-primary"><i class="bi bi-house-door"></i> Kembali ke Beranda</a>
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Halaman Sebelumnya</a>
                                <a href="{{ route('contact') }}" class="btn btn-outline-primary"><i class="bi bi-envelope"></i> Kontak</a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 error-aside text-white p-5 d-none d-md-block">
                            <div class="h-100 d-flex flex-column justify-content-center">
                                <h3 class="fw-semibold mb-3"><i class="bi bi-info-circle"></i> Butuh bantuan?</h3>
                                <p class="mb-4 opacity-90">Jika ini tidak seharusnya terjadi, hubungi admin untuk meminta akses.</p>
                                <ul class="list-unstyled small mb-0 opacity-75">
                                    <li class="mb-2"><i class="bi bi-check2"></i> Pastikan Anda login dengan akun yang benar.</li>
                                    <li class="mb-2"><i class="bi bi-check2"></i> Coba akses menu yang tersedia di navigasi.</li>
                                    <li class="mb-0"><i class="bi bi-check2"></i> Hubungi admin jika masalah berlanjut.</li>
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
    .error-hero { background: linear-gradient(135deg, #fff5f5 0%, #ffecec 100%); position: relative; overflow: hidden; }
    .error-hero .shape { position: absolute; border-radius: 50%; filter: blur(40px); opacity: .6; }
    .error-hero .shape-1 { width: 260px; height: 260px; background: #ffd6d6; top: -40px; left: -40px; }
    .error-hero .shape-2 { width: 220px; height: 220px; background: #ffe3e3; bottom: -30px; right: -30px; }
    .display-code { font-size: 4.5rem; font-weight: 800; }
    .text-danger-gradient { background: linear-gradient(90deg, #dc3545, #ff6b6b); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .error-aside { background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%); }
    @media (min-width: 992px) { .display-code { font-size: 6rem; } }
</style>
@endpush


