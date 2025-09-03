@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Portal Islam Dashboard</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.articles.create') }}"><i data-feather="plus" class="icon-sm me-2"></i> <span class="">Tambah Artikel</span></a>
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.categories.create') }}"><i data-feather="tag" class="icon-sm me-2"></i> <span class="">Tambah Kategori</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Selamat datang di dashboard admin Portal Islam. Kelola artikel, kategori, dan penulis dengan mudah.</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
							<button type="button" class="btn btn-outline-primary">Hari ini</button>
							<button type="button" class="btn btn-outline-primary d-none d-md-block">Minggu ini</button>
							<button type="button" class="btn btn-primary">Bulan ini</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-7 col-xl-8 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-2">
					<h6 class="card-title mb-0">Statistik Portal</h6>
					<div class="dropdown mb-2">
						<button class="btn p-0" type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.articles.index') }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Lihat Semua</span></a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-6 col-md-12 col-xl-5">
						<h3 class="mb-2">{{ $stats['total_articles'] }}</h3>
						<div class="d-flex align-items-baseline">
							<p class="text-success">
								<span>{{ $stats['published_articles'] }}</span>
								<i data-feather="trending-up" class="icon-sm mb-1"></i>
							</p>
						</div>
					</div>
					<div class="col-6 col-md-12 col-xl-7">
						<div id="apexChart1" class="mt-md-3 mt-xl-0"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-5 col-xl-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h6 class="card-title">Ringkasan</h6>
				<div class="row">
					<div class="col-6">
						<div class="d-flex align-items-center">
							<div class="icon-sm bg-primary text-white rounded-3 me-3">
								<i data-feather="book"></i>
							</div>
							<div>
								<h6 class="mb-0">{{ $stats['total_articles'] }}</h6>
								<p class="text-muted mb-0">Total Artikel</p>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="d-flex align-items-center">
							<div class="icon-sm bg-success text-white rounded-3 me-3">
								<i data-feather="check-circle"></i>
							</div>
							<div>
								<h6 class="mb-0">{{ $stats['published_articles'] }}</h6>
								<p class="text-muted mb-0">Artikel Terbit</p>
							</div>
						</div>
					</div>
					<div class="col-6 mt-3">
						<div class="d-flex align-items-center">
							<div class="icon-sm bg-info text-white rounded-3 me-3">
								<i data-feather="user"></i>
							</div>
							<div>
								<h6 class="mb-0">{{ $stats['total_authors'] }}</h6>
								<p class="text-muted mb-0">Total Penulis</p>
							</div>
						</div>
					</div>
					<div class="col-6 mt-3">
						<div class="d-flex align-items-center">
							<div class="icon-sm bg-warning text-white rounded-3 me-3">
								<i data-feather="users"></i>
							</div>
							<div>
								<h6 class="mb-0">{{ $stats['total_users'] }}</h6>
								<p class="text-muted mb-0">Total User</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-8 col-xl-8 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-2">
					<h6 class="card-title mb-0">Artikel Terbaru</h6>
					<div class="dropdown mb-2">
						<button class="btn p-0" type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.articles.index') }}"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">Lihat Semua</span></a>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-hover mb-0">
						<thead>
							<tr>
								<th class="pt-0">Judul</th>
								<th class="pt-0">Penulis</th>
								<th class="pt-0">Status</th>
								<th class="pt-0">Tanggal</th>
							</tr>
						</thead>
						<tbody>
							@foreach($recent_articles as $article)
							<tr>
								<td>
									<div class="d-flex align-items-center">
										<img src="{{ $article->image }}" alt="img" class="img-xs rounded-circle me-2">
										<div>
											<h6 class="mb-0">{{ Str::limit($article->title, 30) }}</h6>
											<small class="text-muted">{{ $article->categories->pluck('name')->implode(', ') }}</small>
										</div>
									</div>
								</td>
								<td>{{ $article->author->name }}</td>
								<td>
									@if($article->status === 'published')
										<span class="badge bg-success">Terbit</span>
									@else
										<span class="badge bg-warning">Draft</span>
									@endif
								</td>
								<td>{{ $article->published_at->format('d M Y') }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-xl-4 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-2">
					<h6 class="card-title mb-0">Penulis Aktif</h6>
				</div>
				<div class="table-responsive">
					<table class="table table-hover mb-0">
						<thead>
							<tr>
								<th class="pt-0">Nama</th>
								<th class="pt-0">Artikel</th>
							</tr>
						</thead>
						<tbody>
							@foreach($recent_authors as $author)
							<tr>
								<td>
									<div class="d-flex align-items-center">
										<div class="me-2">
											<img src="{{ asset('template/assets/images/faces/face1.jpg') }}" alt="img" class="img-xs rounded-circle">
										</div>
										<div>
											<h6 class="mb-0">{{ $author->name }}</h6>
											<small class="text-muted">{{ $author->specialization }}</small>
										</div>
									</div>
								</td>
								<td>{{ $author->articles_count }}</td>
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

@push('plugin-js')
<script src="{{ asset('template/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
@endpush

@push('custom-js')
<script>
	$(function() {
		'use strict';
		
		var options = {
			series: [{{ $stats['published_articles'] }}, {{ $stats['total_articles'] - $stats['published_articles'] }}],
			chart: {
				width: 380,
				type: 'donut',
			},
			labels: ['Terbit', 'Draft'],
			colors: ['#28a745', '#ffc107'],
			responsive: [{
				breakpoint: 480,
				options: {
					chart: {
						width: 200
					},
					legend: {
						position: 'bottom'
					}
				}
			}]
		};

		var chart = new ApexCharts(document.querySelector("#apexChart1"), options);
		chart.render();
	});
</script>
@endpush