@extends('layouts.admin')

@section('title', 'Tambah Kategori Pengumuman')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Tambah Kategori Pengumuman</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcement-categories.index') }}"><i data-feather="list" class="icon-sm me-2"></i> <span class="">Daftar Kategori</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Buat kategori pengumuman baru untuk SMPIT Al-Itqon. Kategori ini akan digunakan untuk mengelompokkan pengumuman.</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<a href="{{ route('admin.announcement-categories.index') }}" class="btn btn-secondary mb-3 mb-md-0">
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
				<form action="{{ route('admin.announcement-categories.store') }}" method="POST">
					@csrf
					<div class="row">
						<div class="col-md-8">
							<div class="mb-3">
								<label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
								<input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
								@error('name')
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
						</div>

						<div class="col-md-4">
							<div class="mb-3">
								<label for="icon" class="form-label">Icon</label>
								<input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', 'fas fa-bell') }}" placeholder="fas fa-bell">
								<small class="form-text text-muted">Contoh: fas fa-bell, fas fa-exclamation, fas fa-info</small>
								@error('icon')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
								<div id="icon-preview" class="mt-2"></div>
							</div>

							<div class="mb-3">
								<label for="color" class="form-label">Warna <span class="text-danger">*</span></label>
								<select class="form-select @error('color') is-invalid @enderror" id="color" name="color" required>
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
								<div id="color-preview" class="mt-2"></div>
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
									<input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
									<label class="form-check-label" for="is_active">
										Aktif
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end gap-2">
						<a href="{{ route('admin.announcement-categories.index') }}" class="btn btn-secondary">
							<i data-feather="x" class="icon-sm me-2"></i>
							Batal
						</a>
						<button type="submit" class="btn btn-primary">
							<i data-feather="save" class="icon-sm me-2"></i>
							Simpan Kategori
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

		// Preview icon
		$('#icon').on('input', function() {
			const iconClass = $(this).val();
			$('#icon-preview').empty();
			if (iconClass) {
				$('#icon-preview').html('<i class="' + iconClass + ' fa-2x text-primary"></i>');
			}
		});

		// Preview color
		$('#color').on('change', function() {
			const color = $(this).val();
			$('#color-preview').empty();
			if (color) {
				$('#color-preview').html('<span class="badge bg-' + color + '">' + color + '</span>');
			}
		});

		// Auto-resize textarea
		$('#description').on('input', function() {
			this.style.height = 'auto';
			this.style.height = (this.scrollHeight) + 'px';
		});

		// Trigger preview on page load
		$('#icon').trigger('input');
		$('#color').trigger('change');
	});
</script>
@endpush
