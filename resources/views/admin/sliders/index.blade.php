@extends('layouts.admin')

@section('title', 'Kelola Slider')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Kelola Slider</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.sliders.create') }}"><i data-feather="plus" class="icon-sm me-2"></i> <span class="">Tambah Slider</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Kelola semua slider SMPIT Al-Itqon. Anda dapat menambah, mengedit, atau menghapus slider.</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<a href="{{ route('admin.sliders.create') }}" class="btn btn-primary mb-3 mb-md-0">
							<i data-feather="plus" class="icon-sm me-2"></i>
							Tambah Slider
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
								<th>ID</th>
								<th>Gambar</th>
								<th>Judul</th>
								<th>Deskripsi</th>
								<th>Link</th>
								<th>Status</th>
								<th>Urutan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($sliders as $slider)
							<tr>
								<td>{{ $slider->id }}</td>
								<td>
									@if(!empty($slider->image))
										<img src="{{ asset('storage/' . $slider->image) }}" alt="img" class="img-xs rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
									@else
										<div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: .8rem; font-weight: bold;">
											SL
										</div>
									@endif
								</td>
								<td>
									<div>
										<h6 class="mb-0">{{ Str::limit($slider->title, 50) }}</h6>
										<small class="text-muted">{{ Str::limit($slider->description, 60) }}</small>
									</div>
								</td>
								<td>{{ Str::limit($slider->description, 50) }}</td>
								<td>
									@if($slider->link)
										<a href="{{ $slider->link }}" target="_blank" class="text-primary">
											<i data-feather="external-link" class="icon-sm"></i>
										</a>
									@else
										<span class="text-muted">-</span>
									@endif
								</td>
								<td>
									@if($slider->is_active)
										<span class="badge bg-success">Aktif</span>
									@else
										<span class="badge bg-secondary">Tidak Aktif</span>
									@endif
								</td>
								<td>{{ $slider->sort_order }}</td>
								<td>
									<div class="dropdown">
										<button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.sliders.show', $slider) }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Lihat</span></a>
											<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.sliders.edit', $slider) }}"><i data-feather="edit" class="icon-sm me-2"></i> <span class="">Edit</span></a>
											@if($slider->link)
											<a class="dropdown-item d-flex align-items-center" href="{{ $slider->link }}" target="_blank"><i data-feather="external-link" class="icon-sm me-2"></i> <span class="">Preview Link</span></a>
											@endif
											<div class="dropdown-divider"></div>
											<form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline">
												@csrf
												@method('DELETE')
												<button type="submit" class="dropdown-item d-flex align-items-center text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus slider ini?')">
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
