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
								<small class="form-text text-muted">Format: JPG, PNG, GIF, WebP (Max: 20MB) - Thumbnail akan dibuat otomatis</small>
								@error('image')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>

						<div class="col-md-4">
							<div class="mb-3">
								<label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
								<select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
									<option value="">Pilih Kategori</option>
									@foreach($categories as $category)
										<option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
											{{ $category->name }}
										</option>
									@endforeach
								</select>
								@error('category_id')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
								<small class="form-text text-muted">
									<button type="button" class="btn btn-link p-0 text-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
										<i data-feather="plus" class="icon-sm me-1"></i>Tambah Kategori Baru
									</button>
								</small>
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

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori Galeri</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="addCategoryForm" action="{{ route('admin.gallery-categories.store') }}" method="POST">
				@csrf
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="modal_name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
								<input type="text" class="form-control @error('name') is-invalid @enderror" id="modal_name" name="name" value="{{ old('name') }}" required>
								@error('name')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="modal_icon" class="form-label">Icon</label>
								<input type="text" class="form-control @error('icon') is-invalid @enderror" id="modal_icon" name="icon" value="{{ old('icon', 'fas fa-folder') }}" placeholder="fas fa-folder">
								<small class="form-text text-muted">Contoh: fas fa-folder, fas fa-camera, fas fa-image</small>
								@error('icon')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="modal_color" class="form-label">Warna <span class="text-danger">*</span></label>
								<select class="form-select @error('color') is-invalid @enderror" id="modal_color" name="color" required>
									<option value="">Pilih Warna</option>
									<option value="primary" {{ old('color') == 'primary' ? 'selected' : '' }}>Primary (Biru)</option>
									<option value="secondary" {{ old('color') == 'secondary' ? 'selected' : '' }}>Secondary (Abu-abu)</option>
									<option value="success" {{ old('color') == 'success' ? 'selected' : '' }}>Success (Hijau)</option>
									<option value="danger" {{ old('color') == 'danger' ? 'selected' : '' }}>Danger (Merah)</option>
									<option value="warning" {{ old('color') == 'warning' ? 'selected' : '' }}>Warning (Kuning)</option>
									<option value="info" {{ old('color') == 'info' ? 'selected' : '' }}>Info (Biru Muda)</option>
									<option value="light" {{ old('color') == 'light' ? 'selected' : '' }}>Light (Terang)</option>
									<option value="dark" {{ old('color') == 'dark' ? 'selected' : '' }}>Dark (Gelap)</option>
								</select>
								@error('color')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-3">
								<label for="modal_description" class="form-label">Deskripsi</label>
								<textarea class="form-control @error('description') is-invalid @enderror" id="modal_description" name="description" rows="4">{{ old('description') }}</textarea>
								@error('description')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="modal_sort_order" class="form-label">Urutan Tampil</label>
								<input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="modal_sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
								<small class="form-text text-muted">Angka kecil akan ditampilkan lebih dulu</small>
								@error('sort_order')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="modal_is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
									<label class="form-check-label" for="modal_is_active">
										Aktif
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">
						<i data-feather="save" class="icon-sm me-2"></i>
						Simpan Kategori
					</button>
				</div>
			</form>
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

		// Modal form functionality
		$('#addCategoryModal').on('show.bs.modal', function () {
			// Reset form
			$('#addCategoryForm')[0].reset();
			$('#modal_icon').val('fas fa-folder');
			$('#modal_is_active').prop('checked', true);
			$('#modal_sort_order').val(0);
			$('#icon-preview, #color-preview').remove();
		});

		// Preview icon in modal
		$('#modal_icon').on('input', function() {
			const iconClass = $(this).val();
			$('#icon-preview').remove();
			if (iconClass) {
				$(this).after('<div id="icon-preview" class="mt-2"><i class="' + iconClass + ' fa-2x"></i></div>');
			}
		});

		// Preview color in modal
		$('#modal_color').on('change', function() {
			const color = $(this).val();
			$('#color-preview').remove();
			if (color) {
				$(this).after('<div id="color-preview" class="mt-2"><span class="badge bg-' + color + '">Preview Warna</span></div>');
			}
		});

		// Auto-resize textarea in modal
		$('#modal_description').on('input', function() {
			this.style.height = 'auto';
			this.style.height = (this.scrollHeight) + 'px';
		});

		// Handle form submission via AJAX
		$('#addCategoryForm').on('submit', function(e) {
			e.preventDefault();
			
			const form = $(this);
			const submitBtn = form.find('button[type="submit"]');
			const originalText = submitBtn.html();
			
			// Disable submit button and show loading
			submitBtn.prop('disabled', true).html('<i class="spinner-border spinner-border-sm me-2"></i>Menyimpan...');
			
			$.ajax({
				url: form.attr('action'),
				method: 'POST',
				data: form.serialize(),
				headers: {
					'X-Requested-With': 'XMLHttpRequest',
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response) {
					// Show success message
					$('.alert').remove();
					$('.card-body').first().prepend(
						'<div class="alert alert-success alert-dismissible fade show" role="alert">' +
						response.message +
						'<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
						'</div>'
					);
					
					// Close modal
					$('#addCategoryModal').modal('hide');
					
					// Reload page to show new category
					setTimeout(function() {
						location.reload();
					}, 1000);
				},
				error: function(xhr) {
					// Handle validation errors
					if (xhr.status === 422) {
						const errors = xhr.responseJSON.errors;
						// Clear previous errors
						$('.is-invalid').removeClass('is-invalid');
						$('.invalid-feedback').remove();
						
						// Show new errors
						$.each(errors, function(field, messages) {
							const input = form.find('[name="' + field + '"]');
							input.addClass('is-invalid');
							input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
						});
					} else {
						// Show general error
						alert('Terjadi kesalahan. Silakan coba lagi.');
					}
				},
				complete: function() {
					// Re-enable submit button
					submitBtn.prop('disabled', false).html(originalText);
				}
			});
		});

	});
</script>
@endpush
