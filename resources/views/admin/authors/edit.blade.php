@extends('layouts.admin')

@section('title', 'Edit Penulis')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Edit Penulis</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.authors.index') }}"><i data-feather="arrow-left" class="icon-sm me-2"></i> <span class="">Kembali</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Edit data penulis SMPIT Al-Itqon. Pastikan mengisi semua field yang diperlukan.</p>
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
				<div class="d-flex align-items-center mb-4">
					@if(!empty($author->avatar))
						<img src="{{ $author->avatar }}" alt="avatar" class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
					@else
						@php
							$name = $author->name;
							$parts = preg_split('/\s+/', trim($name));
							$initials = '';
							foreach ($parts as $p) { $initials .= mb_strtoupper(mb_substr($p, 0, 1)); if (mb_strlen($initials) >= 2) break; }
						@endphp
						<div class="avatar-placeholder rounded-circle mx-auto d-flex align-items-center justify-content-center me-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 2rem; font-weight: bold;">
							{{ $initials }}
						</div>
					@endif
					<div>
						<h5 class="mb-0">{{ $author->name }}</h5>
						<small class="text-muted">{{ $author->email }}</small>
					</div>
				</div>

				<form class="forms-sample" method="POST" action="{{ route('admin.authors.update', $author) }}">
					@csrf
					@method('PUT')
					
					<div class="row">
						<div class="col-md-8">
							<div class="mb-3">
								<label for="name" class="form-label">Nama Penulis <span class="text-danger">*</span></label>
								<input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $author->name) }}" placeholder="Masukkan nama penulis" required>
								@error('name')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="email" class="form-label">Email <span class="text-danger">*</span></label>
								<input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $author->email) }}" placeholder="Masukkan email penulis" required>
								@error('email')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="password" class="form-label">Password (opsional, untuk login)</label>
								<input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 8 karakter">
								@error('password')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="bio" class="form-label">Biografi</label>
								<textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4" placeholder="Masukkan biografi penulis">{{ old('bio', $author->bio) }}</textarea>
								@error('bio')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>

						<div class="col-md-4">
							<div class="mb-3">
								<label for="slug" class="form-label">Slug</label>
								<input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $author->slug) }}" placeholder="slug-penulis" readonly>
								<small class="text-muted">Slug akan dibuat otomatis dari nama penulis</small>
								@error('slug')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="specialization" class="form-label">Spesialisasi <span class="text-danger">*</span></label>
								<select class="form-select @error('specialization') is-invalid @enderror" id="specialization" name="specialization" required>
									<option value="">Pilih Spesialisasi</option>
									<option value="Al-Quran" {{ old('specialization', $author->specialization) == 'Al-Quran' ? 'selected' : '' }}>Al-Quran</option>
									<option value="Hadis" {{ old('specialization', $author->specialization) == 'Hadis' ? 'selected' : '' }}>Hadis</option>
									<option value="Riwayat" {{ old('specialization', $author->specialization) == 'Riwayat' ? 'selected' : '' }}>Riwayat</option>
									<option value="Fikih" {{ old('specialization', $author->specialization) == 'Fikih' ? 'selected' : '' }}>Fikih</option>
									<option value="Tokoh" {{ old('specialization', $author->specialization) == 'Tokoh' ? 'selected' : '' }}>Tokoh</option>
									<option value="Adab" {{ old('specialization', $author->specialization) == 'Adab' ? 'selected' : '' }}>Adab</option>
									<option value="Opini" {{ old('specialization', $author->specialization) == 'Opini' ? 'selected' : '' }}>Opini</option>
									<option value="Perempuan" {{ old('specialization', $author->specialization) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
								</select>
								@error('specialization')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-3">
								<label for="is_active" class="form-label">Status</label>
								<select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
									<option value="1" {{ old('is_active', $author->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
									<option value="0" {{ old('is_active', $author->is_active) == '0' ? 'selected' : '' }}>Tidak Aktif</option>
								</select>
								@error('is_active')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end">
						<a href="{{ route('admin.authors.index') }}" class="btn btn-light me-2">Batal</a>
						<button type="submit" class="btn btn-primary me-2">Update</button>
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
		
		// Auto generate slug from name
		$('#name').on('input', function() {
			var name = $(this).val();
			var slug = name.toLowerCase()
				.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
				.replace(/\s+/g, '-') // collapse whitespace and replace by -
				.replace(/-+/g, '-'); // collapse dashes
			$('#slug').val(slug);
		});
	});
</script>
@endpush
