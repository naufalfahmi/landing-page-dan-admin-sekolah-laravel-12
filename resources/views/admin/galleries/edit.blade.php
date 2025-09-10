@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Edit Galeri</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.galleries.index') }}"><i data-feather="list" class="icon-sm me-2"></i> <span class="">Daftar Galeri</span></a>
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.galleries.show', $gallery) }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Lihat Detail</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Edit galeri "{{ $gallery->title }}". Perbarui informasi yang diperlukan.</p>
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
				<form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data">
					@csrf
					@method('PUT')
					
					<div class="row">
						<div class="col-md-8">
							<div class="mb-3">
								<label for="title" class="form-label">Judul Galeri <span class="text-danger">*</span></label>
								<input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $gallery->title) }}" required>
								@error('title')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="description" class="form-label">Deskripsi</label>
								<textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $gallery->description) }}</textarea>
								@error('description')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="images" class="form-label">Upload Foto Baru</label>
								@if($gallery->image)
									<div class="mb-2">
										<small class="text-muted">Gambar saat ini:</small>
										<div class="d-flex gap-2 mt-1">
											<img src="{{ asset('storage/' . $gallery->image) }}" alt="Current image" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
											@if($gallery->thumbnail)
												<div>
													<small class="text-muted d-block">Thumbnail:</small>
													<img src="{{ asset('storage/' . $gallery->thumbnail) }}" alt="Current thumbnail" class="img-thumbnail" style="max-width: 100px; max-height: 75px;">
												</div>
											@endif
										</div>
									</div>
								@endif
								<input type="file" class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" 
									   id="images" name="images[]" accept="image/*" multiple>
								<small class="form-text text-muted">
									Format: JPG, PNG, GIF, WebP (Max: 20MB per file) - Thumbnail akan dibuat otomatis<br>
									<strong>Tips:</strong> Pilih beberapa foto sekaligus untuk upload multiple. Judul akan otomatis ditambahkan nomor urut (#1, #2, dst.)
								</small>
								@error('images')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
								@error('images.*')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
								
								<!-- Preview area -->
								<div id="imagePreview" class="mt-3" style="display: none;">
									<h6>Preview Foto yang Dipilih:</h6>
									<div id="previewContainer" class="row"></div>
								</div>
							</div>

						</div>

						<div class="col-md-4">
							<div class="mb-3">
								<label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
								<select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
									<option value="">Pilih Kategori</option>
									@foreach($categories as $category)
										<option value="{{ $category->id }}" {{ old('category_id', $gallery->category_id) == $category->id ? 'selected' : '' }}>
											{{ $category->name }}
										</option>
									@endforeach
								</select>
								@error('category_id')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
								<small class="form-text text-muted">
									<a href="{{ route('admin.gallery-categories.create') }}" class="btn btn-link p-0 text-primary" target="_blank">
										<i data-feather="plus" class="icon-sm me-1"></i>Tambah Kategori Baru
									</a>
								</small>
							</div>

							<div class="mb-3">
								<label for="sort_order" class="form-label">Urutan Tampil</label>
								<input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $gallery->sort_order) }}" min="0">
								<small class="form-text text-muted">Angka kecil akan ditampilkan lebih dulu</small>
								@error('sort_order')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $gallery->is_published) ? 'checked' : '' }}>
									<label class="form-check-label" for="is_published">
										Publikasikan
									</label>
								</div>
							</div>

							<div class="mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $gallery->is_featured) ? 'checked' : '' }}>
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
							Update Galeri
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

		// Multiple images preview
		$('#images').on('change', function() {
			const files = this.files;
			const previewContainer = $('#previewContainer');
			const imagePreview = $('#imagePreview');
			
			// Clear previous previews
			previewContainer.empty();
			
			if (files.length > 0) {
				imagePreview.show();
				
				Array.from(files).forEach((file, index) => {
					if (file.type.startsWith('image/')) {
						const reader = new FileReader();
						reader.onload = function(e) {
							const col = $('<div class="col-md-3 mb-3"></div>');
							
							col.html(`
								<div class="card">
									<img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="Preview ${index + 1}">
									<div class="card-body p-2">
										<small class="text-muted">Foto ${index + 1}</small>
										<br>
										<small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
									</div>
								</div>
							`);
							
							previewContainer.append(col);
						};
						reader.readAsDataURL(file);
					}
				});
			} else {
				imagePreview.hide();
			}
		});



});
</script>
@endpush
