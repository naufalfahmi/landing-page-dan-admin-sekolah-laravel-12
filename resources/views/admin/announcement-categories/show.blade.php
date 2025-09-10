@extends('layouts.admin')

@section('title', 'Detail Kategori Pengumuman')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Detail Kategori Pengumuman</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcement-categories.index') }}"><i data-feather="list" class="icon-sm me-2"></i> <span class="">Daftar Kategori</span></a>
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcement-categories.edit', $announcementCategory) }}"><i data-feather="edit" class="icon-sm me-2"></i> <span class="">Edit Kategori</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Detail informasi kategori pengumuman "{{ $announcementCategory->name }}".</p>
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
				<div class="row">
					<div class="col-md-8">
						<div class="mb-4">
							<h4 class="mb-3">
								@if($announcementCategory->icon)
									<i class="{{ $announcementCategory->icon }} text-{{ $announcementCategory->color }} me-2"></i>
								@else
									<i class="fas fa-bell text-{{ $announcementCategory->color }} me-2"></i>
								@endif
								{{ $announcementCategory->name }}
								@if($announcementCategory->is_active)
									<span class="badge bg-success ms-2">Aktif</span>
								@else
									<span class="badge bg-secondary ms-2">Tidak Aktif</span>
								@endif
							</h4>
							
							@if($announcementCategory->description)
								<div class="mb-3">
									<h6>Deskripsi:</h6>
									<p class="text-muted">{{ $announcementCategory->description }}</p>
								</div>
							@endif

							<div class="row">
								<div class="col-md-6">
									<div class="mb-3">
										<h6>Icon:</h6>
										@if($announcementCategory->icon)
											<i class="{{ $announcementCategory->icon }} fa-2x text-{{ $announcementCategory->color }}"></i>
											<small class="text-muted d-block">{{ $announcementCategory->icon }}</small>
										@else
											<span class="text-muted">Tidak ada icon</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<h6>Warna:</h6>
										<span class="badge bg-{{ $announcementCategory->color }} fs-6">{{ ucfirst($announcementCategory->color) }}</span>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="mb-3">
										<h6>Urutan Tampil:</h6>
										<span class="badge bg-info fs-6">{{ $announcementCategory->sort_order }}</span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<h6>Jumlah Pengumuman:</h6>
										<span class="badge bg-primary fs-6">{{ $announcementCategory->announcements->count() }}</span>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="mb-3">
										<h6>Dibuat:</h6>
										<span class="text-muted">{{ $announcementCategory->created_at->format('d M Y, H:i') }}</span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<h6>Diperbarui:</h6>
										<span class="text-muted">{{ $announcementCategory->updated_at->format('d M Y, H:i') }}</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="card">
							<div class="card-header">
								<h6 class="mb-0">Aksi</h6>
							</div>
							<div class="card-body">
								<div class="d-grid gap-2">
									<a href="{{ route('admin.announcement-categories.edit', $announcementCategory) }}" class="btn btn-primary">
										<i data-feather="edit" class="icon-sm me-2"></i>
										Edit Kategori
									</a>
									<a href="{{ route('admin.announcement-categories.index') }}" class="btn btn-outline-secondary">
										<i data-feather="list" class="icon-sm me-2"></i>
										Daftar Kategori
									</a>
									<form action="{{ route('admin.announcement-categories.destroy', $announcementCategory) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-outline-danger w-100">
											<i data-feather="trash-2" class="icon-sm me-2"></i>
											Hapus Kategori
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

				@if($announcementCategory->announcements->count() > 0)
					<hr class="my-4">
					<div class="mb-3">
						<h5>Pengumuman dalam Kategori Ini</h5>
						<p class="text-muted">Berikut adalah daftar pengumuman yang menggunakan kategori ini.</p>
					</div>
					
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Judul Pengumuman</th>
									<th>Status</th>
									<th>Prioritas</th>
									<th>Tanggal Dibuat</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach($announcementCategory->announcements as $index => $announcement)
									<tr>
										<td>{{ $index + 1 }}</td>
										<td>
											<h6 class="mb-0">{{ $announcement->title }}</h6>
											<small class="text-muted">{{ Str::limit($announcement->content, 50) }}</small>
										</td>
										<td>
											@if($announcement->is_published)
												<span class="badge bg-success">Diterbitkan</span>
											@else
												<span class="badge bg-warning">Draft</span>
											@endif
										</td>
										<td>
											@switch($announcement->priority)
												@case('low')
													<span class="badge bg-info">Rendah</span>
													@break
												@case('normal')
													<span class="badge bg-primary">Normal</span>
													@break
												@case('high')
													<span class="badge bg-warning">Tinggi</span>
													@break
												@case('urgent')
													<span class="badge bg-danger">Mendesak</span>
													@break
											@endswitch
										</td>
										<td>{{ $announcement->created_at->format('d M Y') }}</td>
										<td>
											<a href="{{ route('admin.announcements.show', $announcement) }}" class="btn btn-sm btn-outline-primary">
												<i data-feather="eye" class="icon-sm"></i>
											</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@else
					<hr class="my-4">
					<div class="text-center py-4">
						<i data-feather="bell" class="icon-lg text-muted mb-2"></i>
						<h6 class="text-muted">Belum ada pengumuman</h6>
						<p class="text-muted">Kategori ini belum memiliki pengumuman.</p>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
