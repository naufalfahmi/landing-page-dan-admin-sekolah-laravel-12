@extends('layouts.admin')

@section('title', 'Kelola Pena Karsa')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Kelola Pena Karsa</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.pena-karsa.create') }}"><i data-feather="plus" class="icon-sm me-2"></i> <span class="">Tambah Tulisan</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Kelola semua tulisan kreatif Pena Karsa. Tempat untuk opini siswa, esai guru, motivasi islami, dan tulisan kreatif lainnya.</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<a href="{{ route('admin.pena-karsa.create') }}" class="btn btn-primary mb-3 mb-md-0">
							<i data-feather="plus" class="icon-sm me-2"></i>
							Tambah Tulisan
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
				<div class="table-responsive">
					<table id="dataTableExample" class="table">
						<thead>
							<tr>
								<th>ID</th>
								<th>Gambar</th>
								<th>Judul</th>
								<th>Penulis</th>
								<th>Jenis</th>
								<th>Status</th>
								<th>Unggulan</th>
								<th>Dilihat</th>
								<th>Tanggal</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($penaKarsa as $item)
							<tr>
								<td>{{ $item->id }}</td>
								<td>
									@if($item->image)
										<img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
									@else
										<div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
											<i data-feather="image" class="text-muted"></i>
										</div>
									@endif
								</td>
								<td>
									<div class="d-flex flex-column">
										<span class="fw-bold">{{ Str::limit($item->title, 50) }}</span>
										@if($item->tags && count($item->tags) > 0)
											<div class="mt-1">
												@foreach(array_slice($item->tags, 0, 2) as $tag)
													<span class="badge bg-light text-dark me-1">{{ $tag }}</span>
												@endforeach
												@if(count($item->tags) > 2)
													<span class="text-muted">+{{ count($item->tags) - 2 }}</span>
												@endif
											</div>
										@endif
									</div>
								</td>
								<td>
									<div class="d-flex flex-column">
										<span class="fw-bold">{{ $item->author_name }}</span>
										<small class="text-muted">
											@if($item->author_type === 'student')
												<i data-feather="user" class="icon-sm me-1"></i>Siswa
												@if($item->author_class)
													- {{ $item->author_class }}
												@endif
											@elseif($item->author_type === 'teacher')
												<i data-feather="award" class="icon-sm me-1"></i>Guru
												@if($item->author_position)
													- {{ $item->author_position }}
												@endif
											@else
												<i data-feather="user-plus" class="icon-sm me-1"></i>Tamu
											@endif
										</small>
									</div>
								</td>
								<td>
									<span class="badge 
										@if($item->type === 'opinion') bg-info
										@elseif($item->type === 'essay') bg-warning
										@elseif($item->type === 'motivation') bg-success
										@elseif($item->type === 'creative') bg-purple
										@else bg-primary
										@endif text-white">
										{{ $item->type_display }}
									</span>
								</td>
								<td>
									<span class="badge 
										@if($item->status === 'published') bg-success
										@elseif($item->status === 'draft') bg-warning
										@else bg-secondary
										@endif text-white">
										{{ ucfirst($item->status) }}
									</span>
								</td>
								<td>
									@if($item->is_featured)
										<span class="badge bg-warning text-dark">
											<i data-feather="star" class="icon-sm me-1"></i>Unggulan
										</span>
									@else
										<span class="text-muted">-</span>
									@endif
								</td>
								<td>
									<span class="badge bg-light text-dark">
										<i data-feather="eye" class="icon-sm me-1"></i>{{ number_format($item->views) }}
									</span>
								</td>
								<td>
									<div class="d-flex flex-column">
										<small class="text-muted">
											@if($item->published_at)
												{{ $item->published_at->format('d M Y') }}
											@else
												{{ $item->created_at->format('d M Y') }}
											@endif
										</small>
										<small class="text-muted">
											{{ $item->created_at->format('H:i') }}
										</small>
									</div>
								</td>
								<td>
									<div class="dropdown">
										<button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.pena-karsa.show', $item) }}">
												<i data-feather="eye" class="icon-sm me-2"></i>
												<span>Lihat</span>
											</a>
											<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.pena-karsa.edit', $item) }}">
												<i data-feather="edit" class="icon-sm me-2"></i>
												<span>Edit</span>
											</a>
											<div class="dropdown-divider"></div>
											<form action="{{ route('admin.pena-karsa.destroy', $item) }}" method="POST" class="d-inline">
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
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="10" class="text-center py-4">
									<div class="d-flex flex-column align-items-center">
										<i data-feather="edit-3" class="icon-lg text-muted mb-2"></i>
										<p class="text-muted mb-0">Belum ada tulisan Pena Karsa</p>
										<a href="{{ route('admin.pena-karsa.create') }}" class="btn btn-primary btn-sm mt-2">
											<i data-feather="plus" class="icon-sm me-1"></i>
											Tambah Tulisan Pertama
										</a>
									</div>
								</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
				
				@if($penaKarsa->hasPages())
				<div class="d-flex justify-content-center mt-4">
					{{ $penaKarsa->links() }}
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection

@push('custom-js')
<script>
	$(document).ready(function() {
		$('#dataTableExample').DataTable({
			"pageLength": 25,
			"responsive": true,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
			},
			"columnDefs": [
				{ "orderable": false, "targets": [1, 9] } // Disable sorting for image and action columns
			]
		});
	});
</script>
@endpush
