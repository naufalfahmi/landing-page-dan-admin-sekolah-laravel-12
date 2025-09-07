@extends('layouts.admin')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Edit Pengumuman</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcements.index') }}"><i data-feather="list" class="icon-sm me-2"></i> <span class="">Daftar Pengumuman</span></a>
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcements.show', $announcement) }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Lihat Detail</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Edit pengumuman "{{ $announcement->title }}". Perbarui informasi yang diperlukan.</p>
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
				<form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" enctype="multipart/form-data">
					@csrf
					@method('PUT')
					
					<div class="row">
						<div class="col-md-8">
							<div class="mb-3">
								<label for="title" class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
								<input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $announcement->title) }}" required>
								@error('title')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="summary" class="form-label">Ringkasan <span class="text-danger">*</span></label>
								<textarea class="form-control @error('summary') is-invalid @enderror" id="summary" name="summary" rows="3" required>{{ old('summary', $announcement->summary) }}</textarea>
								@error('summary')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="content" class="form-label">Konten <span class="text-danger">*</span></label>
								<textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content', $announcement->content) }}</textarea>
								@error('content')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>

						<div class="col-md-4">
							<div class="mb-3">
								<label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
								<select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
									<option value="">Pilih Kategori</option>
									@foreach($categories as $key => $label)
										<option value="{{ $key }}" {{ old('category', $announcement->category) == $key ? 'selected' : '' }}>{{ $label }}</option>
									@endforeach
								</select>
								@error('category')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="priority" class="form-label">Prioritas <span class="text-danger">*</span></label>
								<select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
									<option value="">Pilih Prioritas</option>
									@foreach($priorities as $key => $label)
										<option value="{{ $key }}" {{ old('priority', $announcement->priority) == $key ? 'selected' : '' }}>{{ $label }}</option>
									@endforeach
								</select>
								@error('priority')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="attachment" class="form-label">Lampiran</label>
								@if($announcement->attachment)
									<div class="mb-2">
										<small class="text-muted">File saat ini:</small>
										<a href="{{ $announcement->attachment }}" target="_blank" class="d-block">
											<i data-feather="file" class="icon-sm me-1"></i>
											{{ $announcement->attachment_name ?? 'Download' }}
										</a>
									</div>
								@endif
								<input type="file" class="form-control @error('attachment') is-invalid @enderror" id="attachment" name="attachment" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
								<small class="form-text text-muted">Format: PDF, JPG, PNG, DOC, DOCX (Max: 10MB)</small>
								@error('attachment')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $announcement->is_published) ? 'checked' : '' }}>
									<label class="form-check-label" for="is_published">
										Publikasikan
									</label>
								</div>
							</div>

							<div class="mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $announcement->is_featured) ? 'checked' : '' }}>
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
							Update Pengumuman
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
	});
</script>
@endpush
