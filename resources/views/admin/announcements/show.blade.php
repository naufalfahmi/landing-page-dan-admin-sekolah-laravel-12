@extends('layouts.admin')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Detail Pengumuman</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcements.index') }}"><i data-feather="list" class="icon-sm me-2"></i> <span class="">Daftar Pengumuman</span></a>
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcements.edit', $announcement) }}"><i data-feather="edit" class="icon-sm me-2"></i> <span class="">Edit</span></a>
							@if($announcement->is_published)
							<a class="dropdown-item d-flex align-items-center" href="{{ route('announcements.show', $announcement->slug) }}" target="_blank"><i data-feather="external-link" class="icon-sm me-2"></i> <span class="">Preview</span></a>
							@endif
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Detail lengkap pengumuman "{{ $announcement->title }}".</p>
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
				<div class="row">
					<div class="col-md-8">
						<div class="mb-4">
							<h4 class="mb-3">{{ $announcement->title }}</h4>
							<div class="d-flex align-items-center mb-3">
								<span class="badge bg-primary me-2">{{ $announcement->category_label }}</span>
								<span class="badge bg-{{ $announcement->priority_color }} me-2">{{ $announcement->priority_label }}</span>
								@if($announcement->is_published)
									<span class="badge bg-success me-2">Terbit</span>
								@else
									<span class="badge bg-warning me-2">Draft</span>
								@endif
								@if($announcement->is_featured)
									<span class="badge bg-info">Featured</span>
								@endif
							</div>
							<p class="text-muted mb-3">{{ $announcement->summary }}</p>
						</div>

						<div class="mb-4">
							<h6 class="mb-3">Konten</h6>
							<div class="border rounded p-3 bg-light">
								{!! nl2br(e($announcement->content)) !!}
							</div>
						</div>

						@if($announcement->attachment)
						<div class="mb-4">
							<h6 class="mb-3">Lampiran</h6>
							<div class="border rounded p-3 bg-light">
								<a href="{{ $announcement->attachment }}" target="_blank" class="btn btn-outline-primary">
									<i data-feather="download" class="icon-sm me-2"></i>
									{{ $announcement->attachment_name ?? 'Download File' }}
								</a>
							</div>
						</div>
						@endif
					</div>

					<div class="col-md-4">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title mb-3">Informasi</h6>
								
								<div class="mb-3">
									<small class="text-muted d-block">ID</small>
									<span class="fw-bold">#{{ $announcement->id }}</span>
								</div>

								<div class="mb-3">
									<small class="text-muted d-block">Kategori</small>
									<span class="badge bg-primary">{{ $announcement->category_label }}</span>
								</div>

								<div class="mb-3">
									<small class="text-muted d-block">Prioritas</small>
									<span class="badge bg-{{ $announcement->priority_color }}">{{ $announcement->priority_label }}</span>
								</div>

								<div class="mb-3">
									<small class="text-muted d-block">Status</small>
									@if($announcement->is_published)
										<span class="badge bg-success">Terbit</span>
									@else
										<span class="badge bg-warning">Draft</span>
									@endif
								</div>

								@if($announcement->is_featured)
								<div class="mb-3">
									<small class="text-muted d-block">Featured</small>
									<span class="badge bg-info">Ya</span>
								</div>
								@endif

								<div class="mb-3">
									<small class="text-muted d-block">Dibuat</small>
									<span>{{ $announcement->created_at->format('d M Y H:i') }}</span>
								</div>

								@if($announcement->published_at)
								<div class="mb-3">
									<small class="text-muted d-block">Diterbitkan</small>
									<span>{{ $announcement->published_at->format('d M Y H:i') }}</span>
								</div>
								@endif

								<div class="mb-3">
									<small class="text-muted d-block">Diperbarui</small>
									<span>{{ $announcement->updated_at->format('d M Y H:i') }}</span>
								</div>

								@if($announcement->views)
								<div class="mb-3">
									<small class="text-muted d-block">Dilihat</small>
									<span>{{ number_format($announcement->views) }} kali</span>
								</div>
								@endif
							</div>
						</div>

						<div class="card mt-3">
							<div class="card-body">
								<h6 class="card-title mb-3">Aksi</h6>
								<div class="d-grid gap-2">
									<a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-warning">
										<i data-feather="edit" class="icon-sm me-2"></i>
										Edit
									</a>
									@if($announcement->is_published)
									<a href="{{ route('announcements.show', $announcement->slug) }}" target="_blank" class="btn btn-info">
										<i data-feather="external-link" class="icon-sm me-2"></i>
										Preview
									</a>
									@endif
									<form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="d-inline">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-danger w-100" onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
											<i data-feather="trash-2" class="icon-sm me-2"></i>
											Hapus
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
