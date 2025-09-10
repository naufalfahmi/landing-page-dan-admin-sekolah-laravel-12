@extends('layouts.admin')

@section('title', 'Detail Tulisan Pena Karsa')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Detail Tulisan Pena Karsa</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.pena-karsa.index') }}"><i data-feather="arrow-left" class="icon-sm me-2"></i> <span class="">Kembali</span></a>
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.pena-karsa.edit', $penaKarsa) }}"><i data-feather="edit" class="icon-sm me-2"></i> <span class="">Edit</span></a>
							<div class="dropdown-divider"></div>
							<form action="{{ route('admin.pena-karsa.destroy', $penaKarsa) }}" method="POST" class="d-inline">
								@csrf
								@method('DELETE')
								<button type="submit" class="dropdown-item d-flex align-items-center text-danger" 
									onclick="return confirm('Apakah Anda yakin ingin menghapus tulisan ini?')">
									<i data-feather="trash-2" class="icon-sm me-2"></i>
									<span>Hapus</span>
								</button>
							</form>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<h4 class="mb-2">{{ $penaKarsa->title }}</h4>
						<p class="text-muted tx-13 mb-3 mb-md-0">Detail lengkap tulisan kreatif Pena Karsa</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<a href="{{ route('admin.pena-karsa.edit', $penaKarsa) }}" class="btn btn-primary me-2">
							<i data-feather="edit" class="icon-sm me-2"></i>
							Edit Tulisan
						</a>
						<a href="{{ route('admin.pena-karsa.index') }}" class="btn btn-light">
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
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				@if($penaKarsa->image)
				<div class="mb-4">
					<img src="{{ asset('storage/' . $penaKarsa->image) }}" alt="{{ $penaKarsa->title }}" class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
				</div>
				@endif

				<div class="mb-4">
					<h5>Ringkasan</h5>
					<p class="text-muted">{{ $penaKarsa->excerpt }}</p>
				</div>

				<div class="mb-4">
					<h5>Konten</h5>
					<div class="content-body">
						{!! $penaKarsa->content !!}
					</div>
				</div>

				@if($penaKarsa->tags && count($penaKarsa->tags) > 0)
				<div class="mb-4">
					<h5>Tag</h5>
					<div class="d-flex flex-wrap gap-2">
						@foreach($penaKarsa->tags as $tag)
						<span class="badge bg-light text-dark">{{ $tag }}</span>
						@endforeach
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<h6 class="card-title mb-3">Informasi Tulisan</h6>
				
				<div class="mb-3">
					<label class="form-label fw-bold">ID</label>
					<p class="text-muted mb-0">#{{ $penaKarsa->id }}</p>
				</div>

				<div class="mb-3">
					<label class="form-label fw-bold">Penulis</label>
					<div class="d-flex align-items-center">
						@if($penaKarsa->author_type === 'student')
							<i data-feather="user" class="icon-sm me-2 text-info"></i>
						@elseif($penaKarsa->author_type === 'teacher')
							<i data-feather="award" class="icon-sm me-2 text-warning"></i>
						@else
							<i data-feather="user-plus" class="icon-sm me-2 text-secondary"></i>
						@endif
						<div>
							<p class="mb-0 fw-bold">{{ $penaKarsa->author_name }}</p>
							<small class="text-muted">
								@if($penaKarsa->author_type === 'student')
									Siswa
									@if($penaKarsa->author_class)
										- {{ $penaKarsa->author_class }}
									@endif
								@elseif($penaKarsa->author_type === 'teacher')
									Guru
									@if($penaKarsa->author_position)
										- {{ $penaKarsa->author_position }}
									@endif
								@else
									Tamu
								@endif
							</small>
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label class="form-label fw-bold">Jenis Tulisan</label>
					<p class="mb-0">
						<span class="badge 
							@if($penaKarsa->type === 'opinion') bg-info
							@elseif($penaKarsa->type === 'essay') bg-warning
							@elseif($penaKarsa->type === 'motivation') bg-success
							@elseif($penaKarsa->type === 'creative') bg-purple
							@else bg-primary
							@endif text-white">
							{{ $penaKarsa->type_display }}
						</span>
					</p>
				</div>

				<div class="mb-3">
					<label class="form-label fw-bold">Status</label>
					<p class="mb-0">
						<span class="badge 
							@if($penaKarsa->status === 'published') bg-success
							@elseif($penaKarsa->status === 'draft') bg-warning
							@else bg-secondary
							@endif text-white">
							{{ ucfirst($penaKarsa->status) }}
						</span>
					</p>
				</div>

				@if($penaKarsa->is_featured)
				<div class="mb-3">
					<label class="form-label fw-bold">Unggulan</label>
					<p class="mb-0">
						<span class="badge bg-warning text-dark">
							<i data-feather="star" class="icon-sm me-1"></i>Ya
						</span>
					</p>
				</div>
				@endif

				<div class="mb-3">
					<label class="form-label fw-bold">Dilihat</label>
					<p class="mb-0">
						<span class="badge bg-light text-dark">
							<i data-feather="eye" class="icon-sm me-1"></i>{{ number_format($penaKarsa->views) }} kali
						</span>
					</p>
				</div>

				<div class="mb-3">
					<label class="form-label fw-bold">Tanggal Dibuat</label>
					<p class="text-muted mb-0">{{ $penaKarsa->created_at->format('d M Y, H:i') }}</p>
				</div>

				@if($penaKarsa->published_at)
				<div class="mb-3">
					<label class="form-label fw-bold">Tanggal Dipublikasi</label>
					<p class="text-muted mb-0">{{ $penaKarsa->published_at->format('d M Y, H:i') }}</p>
				</div>
				@endif

				<div class="mb-3">
					<label class="form-label fw-bold">Terakhir Diupdate</label>
					<p class="text-muted mb-0">{{ $penaKarsa->updated_at->format('d M Y, H:i') }}</p>
				</div>

				<div class="mb-3">
					<label class="form-label fw-bold">Slug URL</label>
					<p class="text-muted mb-0">
						<code>{{ $penaKarsa->slug }}</code>
					</p>
				</div>
			</div>
		</div>

		<div class="card mt-3">
			<div class="card-body">
				<h6 class="card-title mb-3">Aksi</h6>
				<div class="d-grid gap-2">
					<a href="{{ route('admin.pena-karsa.edit', $penaKarsa) }}" class="btn btn-primary">
						<i data-feather="edit" class="icon-sm me-2"></i>
						Edit Tulisan
					</a>
					<a href="{{ route('admin.pena-karsa.index') }}" class="btn btn-light">
						<i data-feather="arrow-left" class="icon-sm me-2"></i>
						Kembali ke Daftar
					</a>
					<form action="{{ route('admin.pena-karsa.destroy', $penaKarsa) }}" method="POST" class="d-inline">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-danger w-100" 
							onclick="return confirm('Apakah Anda yakin ingin menghapus tulisan ini?')">
							<i data-feather="trash-2" class="icon-sm me-2"></i>
							Hapus Tulisan
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('custom-js')
<script>
	$(document).ready(function() {
		// Add some basic styling to the content
		$('.content-body').css({
			'line-height': '1.6',
			'font-size': '16px'
		});
	});
</script>
@endpush
