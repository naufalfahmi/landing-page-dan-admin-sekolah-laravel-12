@extends('layouts.admin')

@section('title', 'Kelola Artikel')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Kelola Artikel</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.articles.create') }}"><i data-feather="plus" class="icon-sm me-2"></i> <span class="">Tambah Artikel</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Kelola semua artikel SMPIT Al-Itqon. Anda dapat menambah, mengedit, atau menghapus artikel.</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<a href="{{ route('admin.articles.create') }}" class="btn btn-primary mb-3 mb-md-0">
							<i data-feather="plus" class="icon-sm me-2"></i>
							Tambah Artikel
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
								<th>No</th>
								<th>Gambar</th>
								<th>Judul</th>
								<th>Penulis</th>
								<th>Kategori</th>
								<th>Status</th>
								<th>Tanggal</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($articles as $article)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>
									@if(!empty($article->image))
										<img src="{{ $article->image }}" alt="img" class="img-xs rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
									@else
										@php
											$name = $article->author->name ?? 'PI';
											$parts = preg_split('/\s+/', trim($name));
											$initials = '';
											foreach ($parts as $p) { $initials .= mb_strtoupper(mb_substr($p, 0, 1)); if (mb_strlen($initials) >= 2) break; }
										@endphp
										<div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: .8rem; font-weight: bold;">
											{{ $initials }}
										</div>
									@endif
								</td>
								<td>
									<div>
										<h6 class="mb-0">{{ Str::limit($article->title, 50) }}</h6>
										<small class="text-muted">{{ Str::limit($article->excerpt, 60) }}</small>
									</div>
								</td>
								<td>{{ $article->author->name }}</td>
								<td>
									@foreach($article->categories as $category)
										<span class="badge bg-primary me-1">{{ $category->name }}</span>
									@endforeach
								</td>
								<td>
									@if($article->status === 'published')
										<span class="badge bg-success">Terbit</span>
									@else
										<span class="badge bg-warning">Draft</span>
									@endif
								</td>
								<td>{{ $article->published_at->format('d M Y') }}</td>
								<td>
									<div class="dropdown">
										<button class="btn p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.articles.show', $article) }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Lihat</span></a>
											<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.articles.edit', $article) }}"><i data-feather="edit" class="icon-sm me-2"></i> <span class="">Edit</span></a>
											<a class="dropdown-item d-flex align-items-center" href="{{ route('article.detail', $article->slug) }}" target="_blank"><i data-feather="external-link" class="icon-sm me-2"></i> <span class="">Preview</span></a>
											@php
												$sl = \App\Models\Shortlink::where('article_id', $article->id)->first();
												$shortUrl = $sl ? $sl->full_url : route('article.detail', $article->slug);
												$waText = urlencode($article->title . ' - ' . $shortUrl);
												$waLink = 'https://api.whatsapp.com/send?text=' . $waText;
											@endphp
											<a class="dropdown-item d-flex align-items-center" href="{{ $waLink }}" target="_blank"><i data-feather="share-2" class="icon-sm me-2"></i> <span class="">Share WhatsApp</span></a>
											<div class="dropdown-divider"></div>
											<form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="d-inline">
												@csrf
												@method('DELETE')
												<button type="submit" class="dropdown-item d-flex align-items-center text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
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
