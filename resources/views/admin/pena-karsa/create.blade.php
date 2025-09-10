@extends('layouts.admin')

@section('title', 'Tambah Tulisan Pena Karsa')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Tambah Tulisan Pena Karsa</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.pena-karsa.index') }}"><i data-feather="arrow-left" class="icon-sm me-2"></i> <span class="">Kembali</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Buat tulisan kreatif baru untuk Pena Karsa. Tempat untuk opini siswa, esai guru, motivasi islami, dan tulisan kreatif lainnya.</p>
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
				<form class="forms-sample" method="POST" action="{{ route('admin.pena-karsa.store') }}" enctype="multipart/form-data" id="penaKarsaForm" novalidate>
					@csrf
					
					<div class="row">
						<div class="col-md-8">
							<div class="mb-3">
								<label for="title" class="form-label">Judul Tulisan <span class="text-danger">*</span></label>
								<input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Masukkan judul tulisan" required>
								@error('title')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="excerpt" class="form-label">Ringkasan <span class="text-danger">*</span></label>
								<textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3" placeholder="Masukkan ringkasan tulisan" required>{{ old('excerpt') }}</textarea>
								@error('excerpt')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="content" class="form-label">Konten <span class="text-danger">*</span></label>
								<textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" placeholder="Masukkan konten tulisan lengkap" required>{{ old('content') }}</textarea>
								@error('content')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="tags" class="form-label">Tag</label>
								<input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags') }}" placeholder="Masukkan tag, pisahkan dengan koma (contoh: motivasi, islami, siswa)">
								<small class="form-text text-muted">Pisahkan setiap tag dengan koma</small>
								@error('tags')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>

						<div class="col-md-4">
							<div class="mb-3">
								<label for="author_name" class="form-label">Nama Penulis <span class="text-danger">*</span></label>
								<input type="text" class="form-control @error('author_name') is-invalid @enderror" id="author_name" name="author_name" value="{{ old('author_name') }}" placeholder="Masukkan nama penulis" required>
								@error('author_name')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="author_type" class="form-label">Jenis Penulis <span class="text-danger">*</span></label>
								<select class="form-select @error('author_type') is-invalid @enderror" id="author_type" name="author_type" required>
									<option value="">Pilih Jenis Penulis</option>
									<option value="student" {{ old('author_type') == 'student' ? 'selected' : '' }}>Siswa</option>
									<option value="teacher" {{ old('author_type') == 'teacher' ? 'selected' : '' }}>Guru</option>
									<option value="guest" {{ old('author_type') == 'guest' ? 'selected' : '' }}>Tamu</option>
								</select>
								@error('author_type')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3" id="author_class_field" style="display: none;">
								<label for="author_class" class="form-label">Kelas</label>
								<input type="text" class="form-control @error('author_class') is-invalid @enderror" id="author_class" name="author_class" value="{{ old('author_class') }}" placeholder="Contoh: 9A, 8B, 7C">
								@error('author_class')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3" id="author_position_field" style="display: none;">
								<label for="author_position" class="form-label">Jabatan</label>
								<input type="text" class="form-control @error('author_position') is-invalid @enderror" id="author_position" name="author_position" value="{{ old('author_position') }}" placeholder="Contoh: Guru Bahasa Indonesia, Wali Kelas 9A">
								@error('author_position')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="type" class="form-label">Jenis Tulisan <span class="text-danger">*</span></label>
								<select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
									<option value="">Pilih Jenis Tulisan</option>
									<option value="article" {{ old('type') == 'article' ? 'selected' : '' }}>Artikel</option>
									<option value="opinion" {{ old('type') == 'opinion' ? 'selected' : '' }}>Opini</option>
									<option value="essay" {{ old('type') == 'essay' ? 'selected' : '' }}>Esai</option>
									<option value="motivation" {{ old('type') == 'motivation' ? 'selected' : '' }}>Motivasi</option>
									<option value="creative" {{ old('type') == 'creative' ? 'selected' : '' }}>Kreatif</option>
								</select>
								@error('type')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="status" class="form-label">Status <span class="text-danger">*</span></label>
								<select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
									<option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
									<option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
									<option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
								</select>
								@error('status')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="published_at" class="form-label">Tanggal Publikasi</label>
								<input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at" value="{{ old('published_at') }}">
								<small class="form-text text-muted">Kosongkan untuk menggunakan tanggal saat ini</small>
								@error('published_at')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<div class="form-check">
									<input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
									<label class="form-check-label" for="is_featured">
										Jadikan sebagai tulisan unggulan
									</label>
								</div>
							</div>

							<div class="mb-3">
								<label for="image" class="form-label">Gambar</label>
								<input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
								<small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
								@error('image')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end">
						<a href="{{ route('admin.pena-karsa.index') }}" class="btn btn-light me-2">Batal</a>
						<button type="submit" class="btn btn-primary">
							<i data-feather="save" class="icon-sm me-2"></i>
							Simpan Tulisan
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@push('plugin-js')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
@endpush

@push('custom-js')
<script>
	$(document).ready(function() {
		// Show/hide author class and position fields based on author type
		$('#author_type').change(function() {
			const authorType = $(this).val();
			const classField = $('#author_class_field');
			const positionField = $('#author_position_field');
			
			classField.hide();
			positionField.hide();
			
			if (authorType === 'student') {
				classField.show();
			} else if (authorType === 'teacher') {
				positionField.show();
			}
		});

		// Trigger change event on page load if there's an old value
		$('#author_type').trigger('change');

		// Auto-set published_at when status is published
		$('#status').change(function() {
			if ($(this).val() === 'published' && !$('#published_at').val()) {
				const now = new Date();
				const year = now.getFullYear();
				const month = String(now.getMonth() + 1).padStart(2, '0');
				const day = String(now.getDate()).padStart(2, '0');
				const hours = String(now.getHours()).padStart(2, '0');
				const minutes = String(now.getMinutes()).padStart(2, '0');
				
				$('#published_at').val(`${year}-${month}-${day}T${hours}:${minutes}`);
			}
		});

		// Convert tags input to array format
		$('#penaKarsaForm').submit(function() {
			const tagsInput = $('#tags');
			const tagsValue = tagsInput.val();
			
			if (tagsValue) {
				const tagsArray = tagsValue.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
				tagsInput.val(JSON.stringify(tagsArray));
			}
		});

		// Initialize CKEditor
		let editor;
		ClassicEditor
			.create(document.querySelector('#content'), { 
				height: '500px',
				toolbar: {
					items: [
						'heading', '|',
						'bold', 'italic', 'underline', 'strikethrough', '|',
						'link', '|',
						'bulletedList', 'numberedList', '|',
						'outdent', 'indent', '|',
						'blockQuote', 'insertTable', '|',
						'undo', 'redo', '|',
						'fontSize', 'fontFamily', '|',
						'textAlignment', '|',
						'removeFormat'
					]
				},
				heading: {
					options: [
						{ model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
						{ model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
						{ model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
						{ model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
					]
				}
			})
			.then(editorInstance => {
				editor = editorInstance;
				editor.ui.view.editable.element.style.minHeight = '500px';
			})
			.catch(error => { 
				console.error('CKEditor error:', error); 
			});

		// Handle form submission
		$('#penaKarsaForm').on('submit', function(e) {
			console.log('Form submission started');
			
			// Update textarea with CKEditor content before submit
			if (editor) {
				console.log('Updating CKEditor content');
				editor.updateSourceElement();
				
				// Validate content is not empty
				const content = editor.getData().trim();
				if (!content) {
					e.preventDefault();
					alert('Konten tidak boleh kosong!');
					return false;
				}
			}
		});
	});
</script>
@endpush
