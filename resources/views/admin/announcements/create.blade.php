@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Tambah Pengumuman</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcements.index') }}"><i data-feather="list" class="icon-sm me-2"></i> <span class="">Daftar Pengumuman</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Buat pengumuman baru untuk SMPIT Al-Itqon. Isi semua field yang diperlukan.</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary mb-3 mb-md-0">
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
				<form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
					@csrf
					
					<div class="row">
						<div class="col-md-8">
							<div class="mb-3">
								<label for="title" class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
								<input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
								@error('title')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="summary" class="form-label">Ringkasan <span class="text-danger">*</span></label>
								<textarea class="form-control @error('summary') is-invalid @enderror" id="summary" name="summary" rows="3" required>{{ old('summary') }}</textarea>
								@error('summary')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="content" class="form-label">Konten <span class="text-danger">*</span></label>
								<textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
								@error('content')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>

						<div class="col-md-4">
							<div class="mb-3">
								<label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
								<select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
									<option value="">Pilih Kategori</option>
									@foreach($categories as $id => $name)
										<option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
									@endforeach
								</select>
								<small class="form-text text-muted">
									<button type="button" class="btn btn-link p-0 text-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus icon-sm me-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>Tambah Kategori Baru
									</button>
								</small>
								@error('category_id')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
								<select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
									<option value="">Pilih Prioritas</option>
									@foreach($priorities as $key => $label)
										<option value="{{ $key }}" {{ old('priority') == $key ? 'selected' : '' }}>{{ $label }}</option>
									@endforeach
								</select>
								@error('priority')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="attachment" class="form-label">Lampiran</label>
								<input type="file" class="form-control @error('attachment') is-invalid @enderror" id="attachment" name="attachment" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
								<small class="form-text text-muted">Format: PDF, JPG, PNG, DOC, DOCX (Max: 10MB)</small>
								@error('attachment')
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
						<a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary me-2">Batal</a>
						<button type="submit" class="btn btn-primary">
							<i data-feather="save" class="icon-sm me-2"></i>
							Simpan Pengumuman
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori Baru</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="addCategoryForm">
				<div class="modal-body">
					<div class="mb-3">
						<label for="category_name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="category_name" name="name" required>
					</div>
					<div class="mb-3">
						<label for="category_description" class="form-label">Deskripsi</label>
						<textarea class="form-control" id="category_description" name="description" rows="3"></textarea>
					</div>
					<div class="mb-3">
						<label for="category_color" class="form-label">Warna</label>
						<input type="color" class="form-control form-control-color" id="category_color" name="color" value="#007bff">
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

		// Handle add category form submission
		$('#addCategoryForm').on('submit', function(e) {
			e.preventDefault();
			
			const formData = new FormData(this);
			const submitBtn = $(this).find('button[type="submit"]');
			const originalText = submitBtn.html();
			
			// Show loading state
			submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...');
			submitBtn.prop('disabled', true);
			
			$.ajax({
				url: '{{ route("admin.announcements.category.store") }}',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response) {
					if (response.success) {
						// Add new option to select
						const newOption = new Option(response.category.name, response.category.id, true, true);
						$('#category_id').append(newOption).trigger('change');
						
						// Show success message
						toastr.success(response.message);
						
						// Close modal and reset form
						$('#addCategoryModal').modal('hide');
						$('#addCategoryForm')[0].reset();
						$('#category_color').val('#007bff');
					}
				},
				error: function(xhr) {
					let errorMessage = 'Terjadi kesalahan saat menyimpan kategori';
					
					if (xhr.responseJSON && xhr.responseJSON.errors) {
						const errors = xhr.responseJSON.errors;
						if (errors.name) {
							errorMessage = errors.name[0];
						}
					} else if (xhr.responseJSON && xhr.responseJSON.message) {
						errorMessage = xhr.responseJSON.message;
					}
					
					toastr.error(errorMessage);
				},
				complete: function() {
					// Reset button state
					submitBtn.html(originalText);
					submitBtn.prop('disabled', false);
				}
			});
		});

		// Reset form when modal is hidden
		$('#addCategoryModal').on('hidden.bs.modal', function() {
			$('#addCategoryForm')[0].reset();
			$('#category_color').val('#007bff');
		});
	});
</script>
@endpush
