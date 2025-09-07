@extends('layouts.app')

@section('title', 'Hubungi Kami - ' . config('app.name'))

@section('meta')
<meta name="description" content="Hubungi kami untuk informasi lebih lanjut tentang sekolah. Kirim pesan atau kunjungi lokasi sekolah kami di Jl. KH. Sholeh Iskandar Km.2 Kd. Badak Bogor.">
<meta name="keywords" content="kontak sekolah, hubungi kami, lokasi sekolah, alamat sekolah, informasi sekolah">
<meta property="og:title" content="Hubungi Kami - {{ config('app.name') }}">
<meta property="og:description" content="Hubungi kami untuk informasi lebih lanjut tentang sekolah">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@endsection

@section('content')
<main class="container mt-4">
    <!-- Page Header -->
    <header class="row mb-4">
        <div class="col-12">
            <h1 class="page-title">Hubungi Kami</h1>
            <p class="page-subtitle">Kami siap membantu Anda dengan informasi yang Anda butuhkan</p>
        </div>
    </header>


    <!-- Contact Section -->
    <section class="row g-4">
        <!-- Contact Form -->
        <div class="col-lg-6 col-md-6">
            <div class="card contact-card h-100">
                <div class="card-body">
                    <h2 class="card-title mb-4">
                        <i class="fas fa-paper-plane text-primary me-2"></i>
                        Hubungi Kami
                    </h2>
                    <p class="text-muted mb-4">Kirim pesan kepada kami dan kami akan merespons secepat mungkin.</p>
                    
                    <form id="contactForm" method="POST" action="#" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user text-primary me-1"></i>
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="name" name="name" required 
                                   placeholder="Masukkan nama lengkap Anda">
                            <div class="invalid-feedback">
                                Mohon masukkan nama lengkap Anda.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope text-primary me-1"></i>
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" id="email" name="email" required 
                                   placeholder="contoh@email.com">
                            <div class="invalid-feedback">
                                Mohon masukkan alamat email yang valid.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">
                                <i class="fas fa-tag text-primary me-1"></i>
                                Subjek <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="">Pilih subjek pesan</option>
                                <option value="informasi-pendaftaran">Informasi Pendaftaran</option>
                                <option value="informasi-sekolah">Informasi Sekolah</option>
                                <option value="keluhan-saran">Keluhan & Saran</option>
                                <option value="kerjasama">Kerjasama</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <div class="invalid-feedback">
                                Mohon pilih subjek pesan.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">
                                <i class="fas fa-comment text-primary me-1"></i>
                                Pesan <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="message" name="message" rows="5" required 
                                      placeholder="Tuliskan pesan Anda di sini..."></textarea>
                            <div class="invalid-feedback">
                                Mohon tuliskan pesan Anda.
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Google Maps -->
        <div class="col-lg-6 col-md-6">
            <div class="card contact-card h-100">
                <div class="card-body">
                    <h2 class="card-title mb-4">
                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                        Lokasi Sekolah
                    </h2>
                    <p class="text-muted mb-4">Kunjungi kami di alamat berikut:</p>
                    
                    <!-- Contact Info -->
                    <div class="contact-info mb-4">
                        <div class="contact-item mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-map-marker-alt text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="mb-1">Alamat</h6>
                                    <p class="text-muted mb-0">Jl. KH. Sholeh Iskandar Km.2 Kd. Badak Bogor</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-item mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-phone text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="mb-1">Telepon</h6>
                                    <p class="text-muted mb-0">
                                        <a href="tel:+628151888930" class="text-decoration-none">+62 815 1888 930</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-item mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-envelope text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="mb-1">Email</h6>
                                    <p class="text-muted mb-0">
                                        <a href="mailto:info@admin.com" class="text-decoration-none">info@admin.com</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Google Maps Embed -->
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.1234567890123!2d106.1234567890123!3d-6.123456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sJl.%20KH.%20Sholeh%20Iskandar%20Km.2%20Kd.%20Badak%20Bogor!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid"
                            width="100%" 
                            height="300" 
                            style="border:0; border-radius: 8px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Sekolah - Jl. KH. Sholeh Iskandar Km.2 Kd. Badak Bogor">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Info Section -->
    <section class="row mt-5">
        <div class="col-12">
            <div class="operational-card">
                <div class="operational-header">
                    <div class="operational-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="operational-title">Jam Operasional</h3>
                    <p class="operational-subtitle">Kami siap melayani Anda pada jam berikut</p>
                </div>
                <div class="operational-grid">
                    <div class="operational-item weekdays">
                        <div class="operational-day">
                            <i class="fas fa-calendar-week"></i>
                            <span>Senin - Jumat</span>
                        </div>
                        <div class="operational-time">
                            <i class="fas fa-clock"></i>
                            <span>07:00 - 15:00 WIB</span>
                        </div>
                        <div class="operational-status open">
                            <i class="fas fa-check-circle"></i>
                            <span>Buka</span>
                        </div>
                    </div>
                    
                    <div class="operational-item saturday">
                        <div class="operational-day">
                            <i class="fas fa-calendar-day"></i>
                            <span>Sabtu</span>
                        </div>
                        <div class="operational-time">
                            <i class="fas fa-clock"></i>
                            <span>07:00 - 12:00 WIB</span>
                        </div>
                        <div class="operational-status open">
                            <i class="fas fa-check-circle"></i>
                            <span>Buka</span>
                        </div>
                    </div>
                    
                    <div class="operational-item sunday">
                        <div class="operational-day">
                            <i class="fas fa-calendar-times"></i>
                            <span>Minggu</span>
                        </div>
                        <div class="operational-time">
                            <i class="fas fa-clock"></i>
                            <span>Libur</span>
                        </div>
                        <div class="operational-status closed">
                            <i class="fas fa-times-circle"></i>
                            <span>Tutup</span>
                        </div>
                    </div>
                </div>
                
                <div class="operational-note">
                    <i class="fas fa-info-circle"></i>
                    <span>Untuk informasi lebih lanjut, silakan hubungi kami melalui kontak yang tersedia.</span>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('styles')
<style>
/* Contact Page Styling */
.contact-card {
    border: none;
    box-shadow: 0 8px 32px rgba(3, 172, 165, 0.15);
    border-radius: 20px;
    transition: all 0.4s ease;
    background: linear-gradient(135deg, #ffffff 0%, #f8fffe 100%);
    border: 1px solid rgba(3, 172, 165, 0.1);
}

.contact-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 48px rgba(3, 172, 165, 0.25);
    border-color: rgba(3, 172, 165, 0.2);
}

.contact-card .card-body {
    padding: 2.5rem;
}

.contact-card .card-title {
    color: #333;
    font-weight: 700;
    font-size: 1.5rem;
    border-bottom: 3px solid #03aca5;
    padding-bottom: 0.75rem;
    margin-bottom: 1.5rem;
    position: relative;
}

/* Icon Styling */
.contact-card .card-title i,
.contact-item i,
.form-label i,
.operational-hours i {
    color: #03aca5 !important;
}

.contact-card .card-title::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #03aca5, #02d4c7);
    border-radius: 2px;
}

.contact-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(3, 172, 165, 0.1);
    transition: all 0.3s ease;
}

.contact-item:last-child {
    border-bottom: none;
}

.contact-item:hover {
    background: rgba(3, 172, 165, 0.05);
    border-radius: 8px;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
}

.contact-item h6 {
    color: #333;
    font-weight: 700;
    margin-bottom: 0.25rem;
    font-size: 1rem;
}

.contact-item .text-muted {
    color: #666 !important;
    font-weight: 500;
}

.contact-item a {
    color: #03aca5 !important;
    font-weight: 600;
    transition: all 0.3s ease;
}

.contact-item a:hover {
    color: #029a94 !important;
    text-decoration: underline !important;
}

.map-container {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(3, 172, 165, 0.2);
    border: 2px solid rgba(3, 172, 165, 0.1);
    transition: all 0.3s ease;
}

.map-container:hover {
    box-shadow: 0 12px 40px rgba(3, 172, 165, 0.3);
    border-color: rgba(3, 172, 165, 0.2);
}

/* Operational Hours - Enhanced Design */
.operational-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fffe 100%);
    border-radius: 25px;
    padding: 3rem 2rem;
    box-shadow: 0 12px 40px rgba(3, 172, 165, 0.15);
    border: 1px solid rgba(3, 172, 165, 0.1);
    position: relative;
    overflow: hidden;
}

.operational-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #03aca5, #02d4c7, #03aca5);
}

.operational-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.operational-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #03aca5, #02d4c7);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    box-shadow: 0 8px 25px rgba(3, 172, 165, 0.3);
}

.operational-icon i {
    font-size: 2rem;
    color: #ffffff;
}

.operational-title {
    color: #03aca5;
    font-weight: 800;
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.operational-subtitle {
    color: #666;
    font-size: 1.1rem;
    font-weight: 500;
    margin-bottom: 0;
}

.operational-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.operational-item {
    background: #ffffff;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(3, 172, 165, 0.1);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.operational-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #03aca5, #02d4c7);
}

.operational-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 40px rgba(3, 172, 165, 0.2);
}

.operational-day {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.operational-day i {
    color: #03aca5;
    font-size: 1.2rem;
    width: 20px;
}

.operational-day span {
    color: #333;
    font-weight: 700;
    font-size: 1.1rem;
}

.operational-time {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.operational-time i {
    color: #666;
    font-size: 1rem;
    width: 20px;
}

.operational-time span {
    color: #555;
    font-weight: 600;
    font-size: 1rem;
}

.operational-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.9rem;
    width: fit-content;
}

.operational-status.open {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
    border: 1px solid #c3e6cb;
}

.operational-status.closed {
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.operational-status i {
    font-size: 0.9rem;
}

.operational-note {
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    border-radius: 15px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    border-left: 4px solid #03aca5;
}

.operational-note i {
    color: #03aca5;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.operational-note span {
    color: #333;
    font-weight: 500;
    line-height: 1.5;
}

/* Form Styling */
.form-control,
.form-select {
    border: 2px solid rgba(3, 172, 165, 0.2);
    border-radius: 12px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
}

.form-control:focus,
.form-select:focus {
    border-color: #03aca5;
    box-shadow: 0 0 0 0.3rem rgba(3, 172, 165, 0.2);
    background: #ffffff;
    transform: translateY(-1px);
}

.form-label {
    color: #333;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.form-label .text-danger {
    color: #e74c3c !important;
}

.btn-primary {
    background: linear-gradient(135deg, #03aca5 0%, #02d4c7 100%);
    border: none;
    border-radius: 12px;
    font-weight: 700;
    padding: 1rem 2rem;
    font-size: 1.1rem;
    transition: all 0.4s ease;
    box-shadow: 0 4px 20px rgba(3, 172, 165, 0.3);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #029a94 0%, #02c4b7 100%);
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(3, 172, 165, 0.4);
}

.btn-primary:active {
    transform: translateY(-1px);
}

/* Page Header Styling */
.page-title {
    color: #03aca5;
    font-weight: 800;
    text-align: center;
    margin-bottom: 1rem;
    position: relative;
}

.page-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #03aca5, #02d4c7);
    border-radius: 2px;
}

.page-subtitle {
    color: #666;
    text-align: center;
    font-weight: 500;
    font-size: 1.1rem;
}


/* Mobile Responsive */
@media (max-width: 768px) {
    .contact-card .card-body {
        padding: 2rem;
    }
    
    .contact-card .card-title {
        font-size: 1.3rem;
    }
    
    .map-container iframe {
        height: 250px;
    }
    
    .operational-card {
        padding: 2rem 1.5rem;
    }
    
    .operational-icon {
        width: 60px;
        height: 60px;
    }
    
    .operational-icon i {
        font-size: 1.5rem;
    }
    
    .operational-title {
        font-size: 1.5rem;
    }
    
    .operational-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .operational-item {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .contact-card .card-body {
        padding: 1.5rem;
    }
    
    .map-container iframe {
        height: 200px;
    }
    
    .operational-card {
        padding: 1.5rem 1rem;
    }
    
    .operational-icon {
        width: 50px;
        height: 50px;
    }
    
    .operational-icon i {
        font-size: 1.2rem;
    }
    
    .operational-title {
        font-size: 1.3rem;
    }
    
    .operational-item {
        padding: 1.25rem;
    }
    
    .operational-note {
        padding: 1rem;
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .page-title {
        font-size: 1.75rem;
    }
    
    .btn-primary {
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
    }
}

/* Animation for form elements */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.contact-card {
    animation: slideInUp 0.6s ease-out;
}

.contact-card:nth-child(2) {
    animation-delay: 0.2s;
}

/* Success Alert Styling */
.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border: 1px solid #03aca5;
    border-radius: 12px;
    color: #155724;
    font-weight: 600;
}

.alert-success .btn-close {
    background: none;
    border: none;
    font-size: 1.2rem;
    color: #03aca5;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('contactForm');
    
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        event.stopPropagation();
        
        // Remove previous validation classes
        form.classList.remove('was-validated');
        
        // Check if form is valid
        if (form.checkValidity()) {
            // Here you would typically send the form data to your server
            // For now, we'll just show a success message
            showSuccessMessage();
        } else {
            form.classList.add('was-validated');
        }
    });
    
    function showSuccessMessage() {
        // Create success alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-success alert-dismissible fade show';
        alertDiv.innerHTML = `
            <i class="fas fa-check-circle me-2"></i>
            <strong>Pesan berhasil dikirim!</strong> Terima kasih atas pesan Anda. Kami akan merespons secepat mungkin.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Insert alert before form
        form.parentNode.insertBefore(alertDiv, form);
        
        // Reset form
        form.reset();
        form.classList.remove('was-validated');
        
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
});
</script>
@endpush
