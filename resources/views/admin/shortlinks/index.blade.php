@extends('layouts.admin')

@section('title', 'Kelola Shortlink')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Kelola Shortlink</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#createShortlinkModal"><i data-feather="plus" class="icon-sm me-2"></i> <span class="">Tambah Shortlink</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Kelola semua shortlink SMPIT Al-Itqon. Buat link pendek untuk memudahkan berbagi.</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<button type="button" class="btn btn-primary mb-3 mb-md-0" data-bs-toggle="modal" data-bs-target="#createShortlinkModal">
							<i data-feather="plus" class="icon-sm me-2"></i>
							Tambah Shortlink
						</button>
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
				<div class="table-responsive">
					<table id="dataTableExample" class="table">
						<thead>
							<tr>
								<th>No</th>
								<th>Short Code</th>
								<th>URL Asli</th>
								<th>URL Pendek</th>
								<th>Jumlah Klik</th>
								<th>Tanggal Dibuat</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($shortlinks as $shortlink)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>
									<span class="badge bg-primary">{{ $shortlink->short_code }}</span>
								</td>
								<td>
									<div>
										<h6 class="mb-0">{{ Str::limit($shortlink->target_url, 50) }}</h6>
									</div>
								</td>
								<td>
									<a href="{{ route('shortlink.redirect', $shortlink->short_code) }}" target="_blank" class="text-primary">
										{{ $shortlink->full_url }}
									</a>
								</td>
								<td>
									<span class="badge bg-info">{{ $shortlink->clicks }}</span>
								</td>
								<td>{{ $shortlink->created_at->format('d M Y H:i') }}</td>
								<td>
									<div class="dropdown">
										<button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item d-flex align-items-center" href="{{ route('shortlink.redirect', $shortlink->short_code) }}" target="_blank"><i data-feather="external-link" class="icon-sm me-2"></i> <span class="">Buka Link</span></a>
											<div class="dropdown-divider"></div>
											<form action="{{ route('admin.shortlinks.destroy', $shortlink) }}" method="POST" class="d-inline">
												@csrf
												@method('DELETE')
												<button type="submit" class="dropdown-item d-flex align-items-center text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus shortlink ini?')">
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

<!-- Create Shortlink Modal -->
<div class="modal fade" id="createShortlinkModal" tabindex="-1" aria-labelledby="createShortlinkModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="createShortlinkModalLabel">Tambah Shortlink Baru</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('admin.shortlinks.store') }}" method="POST">
				@csrf
				<div class="modal-body">
					<div class="mb-3">
						<label for="original_url" class="form-label">URL Asli <span class="text-danger">*</span></label>
						<input type="url" class="form-control @error('original_url') is-invalid @enderror" id="original_url" name="original_url" value="{{ old('original_url') }}" placeholder="https://example.com" required>
						@error('original_url')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div class="mb-3">
						<label for="short_code" class="form-label">Short Code (Opsional)</label>
						<input type="text" class="form-control @error('short_code') is-invalid @enderror" id="short_code" name="short_code" value="{{ old('short_code') }}" placeholder="custom-code">
						<small class="text-muted">Jika kosong, akan dibuat otomatis</small>
						@error('short_code')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Buat Shortlink</button>
				</div>
			</form>
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
