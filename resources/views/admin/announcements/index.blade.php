@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Kelola Pengumuman</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcements.create') }}"><i data-feather="plus" class="icon-sm me-2"></i> <span class="">Tambah Pengumuman</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Kelola semua pengumuman SMPIT Al-Itqon. Anda dapat menambah, mengedit, atau menghapus pengumuman.</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<a href="{{ route('admin.announcements.create') }}" class="btn btn-primary mb-3 mb-md-0">
							<i data-feather="plus" class="icon-sm me-2"></i>
							Tambah Pengumuman
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
						{{ session('success') }}
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
				@endif

				<div class="table-responsive">
					<table id="dataTableExample" class="table">
						<thead>
							<tr>
								<th>No</th>
								<th>Judul</th>
								<th>Kategori</th>
								<th>Prioritas</th>
								<th>Status</th>
								<th>Tanggal</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($announcements as $announcement)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>
									<div>
										<h6 class="mb-0">{{ Str::limit($announcement->title, 50) }}</h6>
										<small class="text-muted">{{ Str::limit($announcement->summary, 60) }}</small>
									</div>
								</td>
								<td>
									<span class="badge bg-primary">{{ $announcement->category_label }}</span>
								</td>
								<td>
									<span class="badge bg-{{ $announcement->priority_color }}">{{ $announcement->priority_label }}</span>
								</td>
								<td>
									@if($announcement->is_published)
										<span class="badge bg-success">Terbit</span>
									@else
										<span class="badge bg-warning">Draft</span>
									@endif
								</td>
								<td>{{ $announcement->published_at ? $announcement->published_at->format('d M Y') : '-' }}</td>
								<td>
									<div class="dropdown">
										<button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcements.show', $announcement) }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Lihat</span></a>
											<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcements.edit', $announcement) }}"><i data-feather="edit" class="icon-sm me-2"></i> <span class="">Edit</span></a>
											@if($announcement->is_published)
											<a class="dropdown-item d-flex align-items-center" href="{{ route('announcements.show', $announcement->slug) }}" target="_blank"><i data-feather="external-link" class="icon-sm me-2"></i> <span class="">Preview</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.announcements.share-whatsapp', $announcement) }}" target="_blank"><i data-feather="share-2" class="icon-sm me-2"></i> <span class="">Bagikan ke WhatsApp</span></a>
											@endif
											@if($announcement->attachment)
											<a class="dropdown-item d-flex align-items-center" href="{{ $announcement->attachment }}" target="_blank"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
											@endif
											<div class="dropdown-divider"></div>
											<form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="d-inline">
												@csrf
												@method('DELETE')
												<button type="submit" class="dropdown-item d-flex align-items-center text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
													<i data-feather="trash-2" class="icon-sm me-2"></i> <span class="">Hapus</span>
												</button>
											</form>
										</div>
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('plugin-css')
<link rel="stylesheet" href="{{ asset('template/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endpush

@push('plugin-js')
<script src="{{ asset('template/assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('template/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-js')
<script>
	$(function() {
		'use strict';
		
		$('#dataTableExample').DataTable({
			"aLengthMenu": [
				[10, 30, 50, -1],
				[10, 30, 50, "All"]
			],
			"iDisplayLength": 10,
			"language": {
				search: ""
			}
		});
		$('#dataTableExample').each(function() {
			var datatable = $(this);
			// SEARCH - Add the placeholder for Search and Turn this into in-line form control
			var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
			search_input.attr('placeholder', 'Search');
			search_input.removeClass('form-control-sm');
			// LENGTH - Inline-Form control
			var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
			length_sel.removeClass('form-control-sm');
		});
	});
</script>
@endpush
