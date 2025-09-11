@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Pengaturan Website</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('home') }}" target="_blank"><i data-feather="external-link" class="icon-sm me-2"></i> <span class="">Lihat Website</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Kelola pengaturan website, SEO, dan logo yang ditampilkan di halaman depan.</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<a href="{{ route('home') }}" target="_blank" class="btn btn-secondary mb-3 mb-md-0">
							<i data-feather="external-link" class="icon-sm me-2"></i>
							Lihat Website
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				@if(session('success'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						{{ session('success') }}
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
				@endif
				<form method="POST" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data">
					@csrf
					
					<!-- SEO & Website Info -->
					<div class="row mb-4">
						<div class="col-12">
							<h6 class="card-title mb-3">
								<i data-feather="search" class="icon-sm me-2"></i>
								SEO & Informasi Website
							</h6>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="site_title" class="form-label">Judul Website</label>
								<input type="text" class="form-control @error('site_title') is-invalid @enderror" id="site_title" name="site_title" value="{{ old('site_title', $site_title) }}" placeholder="SMPIT Al-Itqon">
								@error('site_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
							
							<div class="mb-3">
								<label for="site_subtitle" class="form-label">Subtitle Website</label>
								<input type="text" class="form-control @error('site_subtitle') is-invalid @enderror" id="site_subtitle" name="site_subtitle" value="{{ old('site_subtitle', $site_subtitle) }}" placeholder="Berita dan Artikel Islami">
								<small class="form-text text-muted">Subtitle yang ditampilkan di halaman depan</small>
								@error('site_subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
							
							<div class="mb-3">
								<label for="meta_keywords" class="form-label">Meta Keywords</label>
								<input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $meta_keywords) }}" placeholder="islam, berita, dakwah">
								@error('meta_keywords')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="mb-3">
								<label for="meta_description" class="form-label">Meta Description</label>
								<textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="4" placeholder="Deskripsi singkat website">{{ old('meta_description', $meta_description) }}</textarea>
								@error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
						</div>
					</div>

					<!-- Logo & Icon -->
					<div class="row mb-4">
						<div class="col-12">
							<h6 class="card-title mb-3">
								<i data-feather="image" class="icon-sm me-2"></i>
								Logo & Icon
							</h6>
						</div>
						<div class="col-md-4">
							<div class="mb-3">
								<label for="site_logo" class="form-label">Logo Website</label>
								<input type="file" class="form-control @error('site_logo') is-invalid @enderror" id="site_logo" name="site_logo" accept="image/*">
								<small class="form-text text-muted">Logo di header website (PNG/JPG, Max: 2MB)</small>
								@error('site_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
								@if($site_logo ?? false)
									<div class="mt-2">
										<img src="{{ $site_logo }}" alt="Site Logo" class="img-fluid rounded" style="max-height: 100px;">
									</div>
								@endif
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="mb-3">
								<label for="site_icon" class="form-label">Icon Website</label>
								<input type="file" class="form-control @error('site_icon') is-invalid @enderror" id="site_icon" name="site_icon" accept="image/*">
								<small class="form-text text-muted">Icon browser tab (PNG/ICO, Max: 1MB)</small>
								@error('site_icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
								@if($site_icon)
									<div class="mt-2">
										<img src="{{ $site_icon }}" alt="Site Icon" class="img-fluid rounded" style="max-height: 80px;">
									</div>
								@endif
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="mb-3">
								<label for="favicon" class="form-label">Favicon</label>
								<input type="file" class="form-control @error('favicon') is-invalid @enderror" id="favicon" name="favicon" accept="image/*">
								<small class="form-text text-muted">
									<i data-feather="info" class="icon-sm me-1"></i>
									Favicon browser (ICO/PNG, Max: 500KB) - Icon kecil di tab browser
								</small>
								@error('favicon')<div class="invalid-feedback">{{ $message }}</div>@enderror
								@if($favicon)
									<div class="mt-2">
										<div class="d-flex align-items-center gap-3">
											<img src="{{ $favicon }}" alt="Favicon Preview" class="img-fluid rounded" style="max-height: 40px; border: 1px solid #dee2e6;">
											<div>
												<small class="text-muted d-block">Preview Favicon</small>
												<small class="text-success">
													<i data-feather="check-circle" class="icon-sm me-1"></i>
													Aktif di browser
												</small>
											</div>
										</div>
									</div>
								@else
									<div class="mt-2">
										<div class="alert alert-warning alert-sm">
											<i data-feather="alert-triangle" class="icon-sm me-1"></i>
											Belum ada favicon. Upload favicon untuk menampilkan icon di tab browser.
										</div>
									</div>
								@endif
							</div>
						</div>
					</div>

					<!-- Contact Information -->
					<div class="row mb-4">
						<div class="col-12">
							<h6 class="card-title mb-3">
								<i data-feather="phone" class="icon-sm me-2"></i>
								Informasi Kontak
							</h6>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="contact_email" class="form-label">Email</label>
								<input type="email" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" name="contact_email" value="{{ old('contact_email', $contact_email) }}" placeholder="info@sekolah.com">
								@error('contact_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
							
							<div class="mb-3">
								<label for="contact_phone" class="form-label">Telepon</label>
								<input type="text" class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $contact_phone) }}" placeholder="+62 815 1888 930">
								@error('contact_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="mb-3">
								<label for="contact_whatsapp" class="form-label">WhatsApp</label>
								<input type="text" class="form-control @error('contact_whatsapp') is-invalid @enderror" id="contact_whatsapp" name="contact_whatsapp" value="{{ old('contact_whatsapp', $contact_whatsapp) }}" placeholder="+628151888930">
								@error('contact_whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
							
							<div class="mb-3">
								<label for="contact_address" class="form-label">Alamat</label>
								<textarea class="form-control @error('contact_address') is-invalid @enderror" id="contact_address" name="contact_address" rows="3" placeholder="Jl. KH. Sholeh Iskandar Km.2 Kd. Badak Bogor">{{ old('contact_address', $contact_address) }}</textarea>
								@error('contact_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
							
							<div class="mb-3">
								<label for="contact_address_link" class="form-label">Link Google Maps</label>
								<input type="url" class="form-control @error('contact_address_link') is-invalid @enderror" id="contact_address_link" name="contact_address_link" value="{{ old('contact_address_link', $contact_address_link) }}" placeholder="https://maps.google.com/...">
								<small class="form-text text-muted">
									<i data-feather="info" class="icon-sm me-1"></i>
									Link Google Maps untuk alamat yang bisa diklik di top bar. Kosongkan jika tidak ingin alamat bisa diklik.
								</small>
								@error('contact_address_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
						</div>
					</div>

					<!-- Google Maps -->
					<div class="row mb-4">
						<div class="col-12">
							<h6 class="card-title mb-3">
								<i data-feather="map-pin" class="icon-sm me-2"></i>
								Google Maps
							</h6>
						</div>
						<div class="col-12">
							<div class="mb-3">
								<label for="contact_map_embed" class="form-label">Embed Code Google Maps</label>
								<textarea class="form-control @error('contact_map_embed') is-invalid @enderror" id="contact_map_embed" name="contact_map_embed" rows="6" placeholder="<iframe src=&quot;https://www.google.com/maps/embed?pb=...&quot; width=&quot;100%&quot; height=&quot;450&quot; style=&quot;border:0;&quot; allowfullscreen=&quot;&quot; loading=&quot;lazy&quot; referrerpolicy=&quot;no-referrer-when-downgrade&quot;></iframe>">{{ old('contact_map_embed', $contact_map_embed) }}</textarea>
								<small class="form-text text-muted">
									<i data-feather="info" class="icon-sm me-1"></i>
									Paste embed code dari Google Maps untuk menampilkan peta di halaman "Hubungi Kami". 
									<br><strong>Cara mendapatkan embed code:</strong>
									<br>1. Buka Google Maps → Cari lokasi sekolah
									<br>2. Klik "Share" → Pilih "Embed a map"
									<br>3. Copy kode iframe dan paste di sini
								</small>
								@error('contact_map_embed')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
						</div>
					</div>

					<!-- Operational Hours -->
					<div class="row mb-4">
						<div class="col-12">
							<h6 class="card-title mb-3">
								<i data-feather="clock" class="icon-sm me-2"></i>
								Jam Operasional
							</h6>
						</div>
						<div class="col-md-4">
							<div class="mb-3">
								<label for="operational_hours_weekdays" class="form-label">Senin - Jumat</label>
								<input type="text" class="form-control @error('operational_hours_weekdays') is-invalid @enderror" id="operational_hours_weekdays" name="operational_hours_weekdays" value="{{ old('operational_hours_weekdays', $operational_hours_weekdays) }}" placeholder="07:00 - 15:00 WIB">
								@error('operational_hours_weekdays')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="mb-3">
								<label for="operational_hours_saturday" class="form-label">Sabtu</label>
								<input type="text" class="form-control @error('operational_hours_saturday') is-invalid @enderror" id="operational_hours_saturday" name="operational_hours_saturday" value="{{ old('operational_hours_saturday', $operational_hours_saturday) }}" placeholder="07:00 - 12:00 WIB">
								@error('operational_hours_saturday')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="mb-3">
								<label for="operational_hours_sunday" class="form-label">Minggu</label>
								<input type="text" class="form-control @error('operational_hours_sunday') is-invalid @enderror" id="operational_hours_sunday" name="operational_hours_sunday" value="{{ old('operational_hours_sunday', $operational_hours_sunday) }}" placeholder="Libur">
								@error('operational_hours_sunday')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
						</div>
					</div>

					<!-- Analytics -->
					<div class="row mb-4">
						<div class="col-12">
							<h6 class="card-title mb-3">
								<i data-feather="bar-chart-2" class="icon-sm me-2"></i>
								Analytics & Tracking
							</h6>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="google_analytics" class="form-label">Google Analytics ID</label>
								<input type="text" class="form-control @error('google_analytics') is-invalid @enderror" id="google_analytics" name="google_analytics" value="{{ old('google_analytics', $google_analytics) }}" placeholder="G-XXXXXXXXXX">
								<small class="form-text text-muted">ID Google Analytics untuk tracking pengunjung</small>
								@error('google_analytics')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="mb-3">
								<label for="facebook_pixel" class="form-label">Facebook Pixel ID</label>
								<input type="text" class="form-control @error('facebook_pixel') is-invalid @enderror" id="facebook_pixel" name="facebook_pixel" value="{{ old('facebook_pixel', $facebook_pixel) }}" placeholder="123456789012345">
								<small class="form-text text-muted">ID Facebook Pixel untuk tracking konversi</small>
								@error('facebook_pixel')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
						</div>
					</div>

					<!-- Social Media -->
					<div class="row mb-4">
						<div class="col-12">
							<h6 class="card-title mb-3">
								<i data-feather="share-2" class="icon-sm me-2"></i>
								Sosial Media & Sidebar
							</h6>
						</div>
						
						<!-- Toggle Show/Hide Sidebar -->
						<div class="col-12 mb-3">
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" id="social_sidebar_enabled" name="social_sidebar_enabled" value="1" {{ old('social_sidebar_enabled', $social_sidebar_enabled) ? 'checked' : '' }}>
								<label class="form-check-label" for="social_sidebar_enabled">
									<strong>Tampilkan Sidebar Sosial Media</strong>
								</label>
								<small class="form-text text-muted d-block">Aktifkan untuk menampilkan sidebar sosial media di halaman depan</small>
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-3">
								<label for="instagram_url" class="form-label">
									<i class="fab fa-instagram text-danger me-1"></i>
									Instagram URL
								</label>
								<input type="url" class="form-control @error('instagram_url') is-invalid @enderror" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $instagram_url) }}" placeholder="https://instagram.com/username">
								@error('instagram_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
							
							<div class="mb-3">
								<label for="tiktok_url" class="form-label">
									<i class="fab fa-tiktok text-dark me-1"></i>
									TikTok URL
								</label>
								<input type="url" class="form-control @error('tiktok_url') is-invalid @enderror" id="tiktok_url" name="tiktok_url" value="{{ old('tiktok_url', $tiktok_url) }}" placeholder="https://tiktok.com/@username">
								@error('tiktok_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="mb-3">
								<label for="facebook_url" class="form-label">
									<i class="fab fa-facebook text-primary me-1"></i>
									Facebook URL
								</label>
								<input type="url" class="form-control @error('facebook_url') is-invalid @enderror" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $facebook_url) }}" placeholder="https://facebook.com/username">
								@error('facebook_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
							
							<div class="mb-3">
								<label for="youtube_url" class="form-label">
									<i class="fab fa-youtube text-danger me-1"></i>
									YouTube URL
								</label>
								<input type="url" class="form-control @error('youtube_url') is-invalid @enderror" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $youtube_url) }}" placeholder="https://youtube.com/@username">
								@error('youtube_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
							
							<div class="mb-3">
								<label for="whatsapp_url" class="form-label">
									<i class="fab fa-whatsapp text-success me-1"></i>
									WhatsApp URL
								</label>
								<input type="url" class="form-control @error('whatsapp_url') is-invalid @enderror" id="whatsapp_url" name="whatsapp_url" value="{{ old('whatsapp_url', $whatsapp_url) }}" placeholder="https://wa.me/6281234567890">
								<small class="form-text text-muted">Format: https://wa.me/6281234567890 atau https://wa.me/6281234567890?text=Halo</small>
								@error('whatsapp_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
						</div>
					</div>
					
					<div class="d-flex justify-content-end">
						<button type="submit" class="btn btn-primary">
							<i data-feather="save" class="icon-sm me-2"></i>
							Simpan Pengaturan
						</button>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-css')
<style>
.alert-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    margin-bottom: 0;
}
</style>
@endpush



