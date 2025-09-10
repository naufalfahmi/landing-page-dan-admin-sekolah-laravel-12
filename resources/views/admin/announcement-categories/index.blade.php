@extends('layouts.admin')

@section('title', 'Kelola Kategori Pengumuman')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Kelola Kategori Pengumuman</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcement-categories.create') }}"><i data-feather="plus" class="icon-sm me-2"></i> <span class="">Tambah Kategori</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Kelola semua kategori pengumuman SMPIT Al-Itqon. Anda dapat menambah, mengedit, atau menghapus kategori pengumuman.</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<a href="{{ route('admin.announcement-categories.create') }}" class="btn btn-primary mb-3 mb-md-0">
							<i data-feather="plus" class="icon-sm me-2"></i>
							Tambah Kategori
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
				@if(session('success'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<i data-feather="check-circle" class="icon-sm me-2"></i>
						{{ session('success') }}
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
				@endif

				@if(session('error'))
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<i data-feather="alert-circle" class="icon-sm me-2"></i>
						{{ session('error') }}
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
				@endif

				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Kategori</th>
								<th>Icon</th>
								<th>Warna</th>
								<th>Status</th>
								<th>Urutan</th>
								<th>Jumlah Pengumuman</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($categories as $index => $category)
								<tr>
									<td>{{ $categories->firstItem() + $index }}</td>
									<td>
										<div class="d-flex align-items-center">
											<div class="me-3">
												@if($category->icon)
													<i class="{{ $category->icon }} text-{{ $category->color }}"></i>
												@else
													<i class="fas fa-folder text-{{ $category->color }}"></i>
												@endif
											</div>
											<div>
												<h6 class="mb-0">{{ $category->name }}</h6>
												@if($category->description)
													<small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
												@endif
											</div>
										</div>
									</td>
									<td>
										@if($category->icon)
											<i class="{{ $category->icon }}"></i>
											<small class="text-muted d-block">{{ $category->icon }}</small>
										@else
											<span class="text-muted">-</span>
										@endif
									</td>
									<td>
										<span class="badge bg-{{ $category->color }}">{{ ucfirst($category->color) }}</span>
									</td>
									<td>
										@if($category->is_active)
											<span class="badge bg-success">Aktif</span>
										@else
											<span class="badge bg-secondary">Tidak Aktif</span>
										@endif
									</td>
									<td>
										<span class="badge bg-info">{{ $category->sort_order }}</span>
									</td>
									<td>
										<span class="badge bg-primary">{{ $category->announcements_count }}</span>
									</td>
									<td>
										<div class="dropdown">
											<button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcement-categories.show', $category) }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Lihat</span></a>
												<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcement-categories.edit', $category) }}"><i data-feather="edit" class="icon-sm me-2"></i> <span class="">Edit</span></a>
												<div class="dropdown-divider"></div>
												<form action="{{ route('admin.announcement-categories.destroy', $category) }}" method="POST" class="d-inline">
													@csrf
													@method('DELETE')
													<button type="submit" class="dropdown-item d-flex align-items-center text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
														<i data-feather="trash-2" class="icon-sm me-2"></i> <span class="">Hapus</span>
													</button>
												</form>
											</div>
										</div>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="8" class="text-center py-4">
										<div class="d-flex flex-column align-items-center">
											<i data-feather="folder" class="icon-lg text-muted mb-2"></i>
											<h6 class="text-muted">Belum ada kategori pengumuman</h6>
											<p class="text-muted mb-3">Mulai dengan membuat kategori pengumuman pertama Anda</p>
											<a href="{{ route('admin.announcement-categories.create') }}" class="btn btn-primary">
												<i data-feather="plus" class="icon-sm me-2"></i>
												Tambah Kategori
											</a>
										</div>
									</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>

				@if($categories->hasPages())
					<div class="d-flex justify-content-center mt-4">
						{{ $categories->links() }}
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
