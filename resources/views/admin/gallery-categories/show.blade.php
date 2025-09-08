@extends('layouts.admin')

@section('title', 'Detail Kategori Galeri')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Detail Kategori Galeri</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.gallery-categories.index') }}"><i data-feather="list" class="icon-sm me-2"></i> <span class="">Daftar Kategori</span></a>
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.gallery-categories.edit', $galleryCategory) }}"><i data-feather="edit" class="icon-sm me-2"></i> <span class="">Edit Kategori</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Informasi detail kategori "{{ $galleryCategory->name }}" dan galeri yang terkait.</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<a href="{{ route('admin.gallery-categories.index') }}" class="btn btn-secondary mb-3 mb-md-0">
							<i data-feather="arrow-left" class="icon-sm me-2"></i>
							Kembali
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h6 class="card-title">Informasi Kategori</h6>
				<div class="mb-3">
					<label class="form-label fw-bold">Nama:</label>
					<p class="mb-0">{{ $galleryCategory->name }}</p>
				</div>
				<div class="mb-3">
					<label class="form-label fw-bold">Slug:</label>
					<p class="mb-0 text-muted">{{ $galleryCategory->slug }}</p>
				</div>
				<div class="mb-3">
					<label class="form-label fw-bold">Deskripsi:</label>
					<p class="mb-0">{{ $galleryCategory->description ?: 'Tidak ada deskripsi' }}</p>
				</div>
				<div class="mb-3">
					<label class="form-label fw-bold">Icon:</label>
					<p class="mb-0">
						@if($galleryCategory->icon)
							<i class="{{ $galleryCategory->icon }} fa-2x"></i>
							<small class="text-muted d-block">{{ $galleryCategory->icon }}</small>
						@else
							<i class="fas fa-folder fa-2x"></i>
							<small class="text-muted d-block">fas fa-folder (default)</small>
						@endif
					</p>
				</div>
				<div class="mb-3">
					<label class="form-label fw-bold">Warna:</label>
					<p class="mb-0">
						<span class="badge bg-{{ $galleryCategory->color }}">{{ ucfirst($galleryCategory->color) }}</span>
					</p>
				</div>
				<div class="mb-3">
					<label class="form-label fw-bold">Status:</label>
					<p class="mb-0">
						@if($galleryCategory->is_active)
							<span class="badge bg-success">Aktif</span>
						@else
							<span class="badge bg-secondary">Tidak Aktif</span>
						@endif
					</p>
				</div>
				<div class="mb-3">
					<label class="form-label fw-bold">Urutan:</label>
					<p class="mb-0">{{ $galleryCategory->sort_order }}</p>
				</div>
				<div class="mb-3">
					<label class="form-label fw-bold">Dibuat:</label>
					<p class="mb-0">{{ $galleryCategory->created_at->format('d M Y H:i') }}</p>
				</div>
				<div class="mb-3">
					<label class="form-label fw-bold">Diperbarui:</label>
					<p class="mb-0">{{ $galleryCategory->updated_at->format('d M Y H:i') }}</p>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-8 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4">
					<h6 class="card-title mb-0">Galeri dalam Kategori ({{ $galleryCategory->galleries->count() }})</h6>
					<a href="{{ route('admin.galleries.create') }}" class="btn btn-primary btn-sm">
						<i data-feather="plus" class="icon-sm me-1"></i>
						Tambah Galeri
					</a>
				</div>

				@if($galleryCategory->galleries->count() > 0)
					<div class="row">
						@foreach($galleryCategory->galleries as $gallery)
						<div class="col-md-6 col-lg-4 mb-3">
							<div class="card">
								@if($gallery->thumbnail)
									<img src="{{ asset('storage/' . $gallery->thumbnail) }}" class="card-img-top" alt="{{ $gallery->title }}" style="height: 150px; object-fit: cover;">
								@elseif($gallery->image)
									<img src="{{ asset('storage/' . $gallery->image) }}" class="card-img-top" alt="{{ $gallery->title }}" style="height: 150px; object-fit: cover;">
								@else
									<div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 150px;">
										<i class="fas fa-image fa-3x text-muted"></i>
									</div>
								@endif
								<div class="card-body p-2">
									<h6 class="card-title mb-1">{{ Str::limit($gallery->title, 30) }}</h6>
									<small class="text-muted">{{ Str::limit($gallery->description, 50) }}</small>
									<div class="mt-2">
										@if($gallery->is_published)
											<span class="badge bg-success">Terbit</span>
										@else
											<span class="badge bg-warning">Draft</span>
										@endif
										@if($gallery->is_featured)
											<span class="badge bg-info">Featured</span>
										@endif
									</div>
									<div class="mt-2">
										<a href="{{ route('admin.galleries.show', $gallery) }}" class="btn btn-sm btn-outline-primary">
											<i data-feather="eye" class="icon-sm me-1"></i> Lihat
										</a>
										<a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-sm btn-outline-secondary">
											<i data-feather="edit" class="icon-sm me-1"></i> Edit
										</a>
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				@else
					<div class="text-center py-5">
						<i class="fas fa-images fa-3x text-muted mb-3"></i>
						<h6 class="text-muted">Belum ada galeri dalam kategori ini</h6>
						<a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
							<i data-feather="plus" class="icon-sm me-2"></i>
							Tambah Galeri Pertama
						</a>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
