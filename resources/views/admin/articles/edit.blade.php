@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Edit Artikel</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.articles.index') }}"><i data-feather="arrow-left" class="icon-sm me-2"></i> <span class="">Kembali</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Edit artikel SMPIT Al-Itqon. Pastikan mengisi semua field yang diperlukan.</p>
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
				<form class="forms-sample" method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data">
					@csrf
					@method('PUT')
					
					<div class="row">
						<div class="col-md-8">
							<div class="mb-3">
								<label for="title" class="form-label">Judul Artikel <span class="text-danger">*</span></label>
								<input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $article->title) }}" placeholder="Masukkan judul artikel" required>
								@error('title')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="excerpt" class="form-label">Ringkasan <span class="text-danger">*</span></label>
								<textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3" placeholder="Masukkan ringkasan artikel" required>{{ old('excerpt', $article->excerpt) }}</textarea>
								@error('excerpt')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="content" class="form-label">Konten <span class="text-danger">*</span></label>
								<textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" placeholder="Masukkan konten artikel" required>{{ old('content', $article->content) }}</textarea>
								@error('content')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>

						<div class="col-md-4">
							<div class="mb-3">
								<label for="author_id" class="form-label">Penulis <span class="text-danger">*</span></label>
								<select class="form-select @error('author_id') is-invalid @enderror" id="author_id" name="author_id" required>
									<option value="">Pilih Penulis</option>
									@foreach($authors as $author)
										<option value="{{ $author->id }}" {{ old('author_id', $article->author_id) == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
									@endforeach
								</select>
								@error('author_id')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="categories" class="form-label">Kategori <span class="text-danger">*</span></label>
								<select class="form-select select2 @error('categories') is-invalid @enderror" id="categories" name="categories[]" multiple required>
									@foreach($categories as $category)
										<option value="{{ $category->id }}" {{ in_array($category->id, old('categories', $article->categories->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $category->name }}</option>
									@endforeach
								</select>
								@error('categories')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="image" class="form-label">Gambar</label>
								<input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
								@error('image')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
								@if($article->image)
									<div class="mt-2">
										<img src="{{ $article->image }}" alt="Gambar" class="img-fluid rounded" style="max-height: 120px;">
									</div>
								@endif
							</div>

							<div class="mb-3">
								<label for="status" class="form-label">Status <span class="text-danger">*</span></label>
								<select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
									<option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft</option>
									<option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Terbit</option>
								</select>
								@error('status')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="short_code" class="form-label">Custom Shortlink</label>
								<div class="input-group">
									<span class="input-group-text">{{ url('/s') }}/</span>
									<input type="text" class="form-control @error('short_code') is-invalid @enderror" id="short_code" name="short_code" value="{{ old('short_code', optional($shortlink)->short_code) }}" placeholder="custom-code">
									@error('short_code')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								@if($shortlink)
									<small class="text-muted">Shortlink saat ini: <a href="{{ $shortlink->full_url }}" target="_blank">{{ $shortlink->full_url }}</a></small>
								@endif
								<small class="text-muted d-block">Opsional. Biarkan kosong untuk mempertahankan/generate otomatis.</small>
							</div>

							<div class="mb-3">
								<label for="published_at" class="form-label">Tanggal Terbit</label>
								<input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at" value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}">
								@error('published_at')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end">
						<a href="{{ route('admin.articles.index') }}" class="btn btn-light me-2">Batal</a>
						<button type="submit" class="btn btn-primary me-2">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@push('plugin-css')
<link rel="stylesheet" href="{{ asset('template/assets/vendors/select2/select2.min.css') }}">
@endpush

@push('plugin-js')
<script src="{{ asset('template/assets/vendors/select2/select2.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
@endpush

@push('custom-js')
<script>
	$(function() {
		'use strict';
		
		// Initialize Select2
		$('.select2').select2({
			placeholder: 'Pilih kategori',
			allowClear: true,
			width: '100%'
		});

		// Initialize CKEditor
		ClassicEditor
			.create(document.querySelector('#content'))
			.then(editor => {
				editor.ui.view.editable.element.style.minHeight = '500px';
			})
			.catch(error => { console.error(error); });
	});
</script>
@endpush
