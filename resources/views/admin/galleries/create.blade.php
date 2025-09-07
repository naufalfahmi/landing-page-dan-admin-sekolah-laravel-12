@extends('layouts.admin')

@section('title', 'Tambah Galeri')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Tambah Galeri</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.galleries.index') }}"><i data-feather="list" class="icon-sm me-2"></i> <span class="">Daftar Galeri</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Buat galeri foto baru untuk SMPIT Al-Itqon. Upload gambar dan isi informasi yang diperlukan.</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary mb-3 mb-md-0">
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
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
					@csrf
					
					<div class="row">
						<div class="col-md-8">
							<div class="mb-3">
								<label for="title" class="form-label">Judul Galeri <span class="text-danger">*</span></label>
								<input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
								@error('title')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="description" class="form-label">Deskripsi</label>
								<textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
								@error('description')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="image" class="form-label">Gambar Utama <span class="text-danger">*</span></label>
								<input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" required>
								<small class="form-text text-muted">Format: JPG, PNG, GIF (Max: 5MB)</small>
								@error('image')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="thumbnail" class="form-label">Thumbnail</label>
								<input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" accept="image/*">
								<small class="form-text text-muted">Format: JPG, PNG, GIF (Max: 2MB) - Opsional</small>
								@error('thumbnail')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>

						<div class="col-md-4">
							<div class="mb-3">
								<label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
								<select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
									<option value="">Pilih Kategori</option>
									<option value="kegiatan-belajar" {{ old('category') == 'kegiatan-belajar' ? 'selected' : '' }}>Kegiatan Belajar</option>
									<option value="ekstrakurikuler" {{ old('category') == 'ekstrakurikuler' ? 'selected' : '' }}>Ekstrakurikuler</option>
									<option value="acara-sekolah" {{ old('category') == 'acara-sekolah' ? 'selected' : '' }}>Acara Sekolah</option>
									<option value="fasilitas" {{ old('category') == 'fasilitas' ? 'selected' : '' }}>Fasilitas</option>
								</select>
								@error('category')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="sort_order" class="form-label">Urutan Tampil</label>
								<input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
								<small class="form-text text-muted">Angka kecil akan ditampilkan lebih dulu</small>
								@error('sort_order')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
									<label class="form-check-label" for="is_published">
										Publikasikan
									</label>
								</div>
							</div>

							<div class="mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
									<label class="form-check-label" for="is_featured">
										Featured
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end">
						<a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary me-2">Batal</a>
						<button type="submit" class="btn btn-primary">
							<i data-feather="save" class="icon-sm me-2"></i>
							Simpan Galeri
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@push('custom-js')
<script>
	$(function() {
		'use strict';
		
		// Auto-resize textarea
		$('textarea').on('input', function() {
			this.style.height = 'auto';
			this.style.height = (this.scrollHeight) + 'px';
		});

		// Image preview
		$('#image').on('change', function() {
			const file = this.files[0];
			if (file) {
				const reader = new FileReader();
				reader.onload = function(e) {
					$('#image-preview').remove();
					$('#image').after('<div id="image-preview" class="mt-2"><img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 200px; max-height: 150px;"></div>');
				};
				reader.readAsDataURL(file);
			}
		});

		$('#thumbnail').on('change', function() {
			const file = this.files[0];
			if (file) {
				const reader = new FileReader();
				reader.onload = function(e) {
					$('#thumbnail-preview').remove();
					$('#thumbnail').after('<div id="thumbnail-preview" class="mt-2"><img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 150px; max-height: 100px;"></div>');
				};
				reader.readAsDataURL(file);
			}
		});
	});
</script>
@endpush
