@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">SMPIT Al-Itqon Dashboard</h6>
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
						<p class="text-muted tx-13 mb-3 mb-md-0">Selamat datang di dashboard admin SMPIT Al-Itqon. Kelola artikel, kategori, dan penulis dengan mudah.</p>
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

<!-- Page Views Statistics -->
<div class="row">
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4">
					<h6 class="card-title mb-0">
						<i data-feather="bar-chart-2" class="icon-sm me-2"></i>
						Statistik Pengunjung Website
					</h6>
					<div class="btn-group" role="group" aria-label="Period selector">
						<button type="button" class="btn btn-outline-primary btn-sm" onclick="updatePageViewsStats('today')">Hari Ini</button>
						<button type="button" class="btn btn-outline-primary btn-sm" onclick="updatePageViewsStats('week')">Minggu Ini</button>
						<button type="button" class="btn btn-primary btn-sm" onclick="updatePageViewsStats('month')">Bulan Ini</button>
						<button type="button" class="btn btn-outline-primary btn-sm" onclick="updatePageViewsStats('year')">Tahun Ini</button>
					</div>
				</div>
				
				<!-- Page Views Cards -->
				<div class="row mb-4">
					<div class="col-md-3">
						<div class="card bg-primary text-white">
							<div class="card-body">
								<div class="d-flex justify-content-between">
									<div>
										<h4 class="mb-0" id="total-views">{{ $pageViewsStats['month']['total_views'] }}</h4>
										<p class="mb-0">Total Kunjungan</p>
									</div>
									<div class="align-self-center">
										<i data-feather="eye" class="icon-lg"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card bg-success text-white">
							<div class="card-body">
								<div class="d-flex justify-content-between">
									<div>
										<h4 class="mb-0" id="unique-visitors">{{ $pageViewsStats['month']['unique_visitors'] }}</h4>
										<p class="mb-0">Pengunjung Unik</p>
									</div>
									<div class="align-self-center">
										<i data-feather="users" class="icon-lg"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card bg-info text-white">
							<div class="card-body">
								<div class="d-flex justify-content-between">
									<div>
										<h4 class="mb-0" id="today-views">{{ $pageViewsStats['today']['total_views'] }}</h4>
										<p class="mb-0">Hari Ini</p>
									</div>
									<div class="align-self-center">
										<i data-feather="calendar" class="icon-lg"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card bg-warning text-white">
							<div class="card-body">
								<div class="d-flex justify-content-between">
									<div>
										<h4 class="mb-0" id="week-views">{{ $pageViewsStats['week']['total_views'] }}</h4>
										<p class="mb-0">Minggu Ini</p>
									</div>
									<div class="align-self-center">
										<i data-feather="trending-up" class="icon-lg"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Top Pages -->
				<div class="row">
					<div class="col-md-6">
						<div class="d-flex justify-content-between align-items-center mb-3">
							<h6 class="card-title mb-0">Halaman Terpopuler</h6>
							<div class="btn-group btn-group-sm" role="group" aria-label="Top pages filter">
								<button type="button" class="btn btn-outline-primary btn-sm" onclick="updateTopPages('today')">Hari Ini</button>
								<button type="button" class="btn btn-outline-primary btn-sm" onclick="updateTopPages('week')">Minggu</button>
								<button type="button" class="btn btn-primary btn-sm" onclick="updateTopPages('month')">Bulan</button>
								<button type="button" class="btn btn-outline-primary btn-sm" onclick="updateTopPages('year')">Tahun</button>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-sm">
								<thead>
									<tr>
										<th>Halaman</th>
										<th>Kunjungan</th>
									</tr>
								</thead>
								<tbody id="top-pages">
									@foreach($pageViewsStats['month']['top_pages'] as $page)
									<tr>
										<td>{{ $page->page_title ?: 'Halaman' }}</td>
										<td><span class="badge bg-primary">{{ $page->views }}</span></td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="text-center mt-2">
							<small class="text-muted">Menampilkan 10 halaman terpopuler</small>
						</div>
					</div>
					<div class="col-md-6">
						<h6 class="card-title mb-3">Grafik Kunjungan (30 Hari Terakhir)</h6>
						<div class="chart-container" style="position: relative; height: 200px; overflow-x: auto;">
							<canvas id="pageViewsChart" height="200" style="min-width: 600px;"></canvas>
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
											@if(!empty($author->avatar))
												<img src="{{ $author->avatar }}" alt="img" class="img-xs rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
											@else
												@php
													$name = $author->name;
													$parts = preg_split('/\s+/', trim($name));
													$initials = '';
													foreach ($parts as $p) { $initials .= mb_strtoupper(mb_substr($p, 0, 1)); if (mb_strlen($initials) >= 2) break; }
												@endphp
												<div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: .8rem; font-weight: bold;">
													{{ $initials }}
												</div>
											@endif
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('custom-css')
<style>
.chart-container {
	scrollbar-width: thin;
	scrollbar-color: #007bff #f8f9fa;
}

.chart-container::-webkit-scrollbar {
	height: 8px;
}

.chart-container::-webkit-scrollbar-track {
	background: #f8f9fa;
	border-radius: 4px;
}

.chart-container::-webkit-scrollbar-thumb {
	background: #007bff;
	border-radius: 4px;
}

.chart-container::-webkit-scrollbar-thumb:hover {
	background: #0056b3;
}

.chart-container {
	scroll-behavior: smooth;
}
</style>
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

		// Page Views Chart
		var dailyViewsData = @json($dailyViews);
		var chartContainer = document.querySelector('.chart-container');
		
		// Check if data exists and is valid
		if (dailyViewsData && dailyViewsData.length > 0) {
			var labels = dailyViewsData.map(item => {
				// Format date to be more readable
				var date = new Date(item.date);
				return date.toLocaleDateString('id-ID', { month: 'short', day: 'numeric' });
			});
			var views = dailyViewsData.map(item => parseInt(item.views) || 0);

			var ctx = document.getElementById('pageViewsChart');
			if (ctx) {
				var pageViewsChart = new Chart(ctx.getContext('2d'), {
					type: 'line',
					data: {
						labels: labels,
						datasets: [{
							label: 'Kunjungan',
							data: views,
							borderColor: '#007bff',
							backgroundColor: 'rgba(0, 123, 255, 0.1)',
							tension: 0.4,
							fill: true,
							pointBackgroundColor: '#007bff',
							pointBorderColor: '#ffffff',
							pointBorderWidth: 2,
							pointRadius: 4
						}]
					},
					options: {
						responsive: true,
						maintainAspectRatio: false,
						scales: {
							y: {
								beginAtZero: true,
								ticks: {
									stepSize: 1
								}
							},
							x: {
								ticks: {
									maxTicksLimit: 15,
									autoSkip: false
								}
							}
						},
						plugins: {
							legend: {
								display: false
							},
							tooltip: {
								mode: 'index',
								intersect: false
							}
						},
						interaction: {
							mode: 'nearest',
							axis: 'x',
							intersect: false
						}
					}
				});

				// Auto scroll to the end (most recent data)
				setTimeout(function() {
					if (chartContainer) {
						chartContainer.scrollLeft = chartContainer.scrollWidth;
					}
				}, 100);

				// Add smooth scrolling on hover
				if (chartContainer) {
					chartContainer.addEventListener('wheel', function(e) {
						if (e.deltaY !== 0) {
							e.preventDefault();
							chartContainer.scrollLeft += e.deltaY;
						}
					});

					// Add touch support for mobile
					var startX = 0;
					var scrollLeft = 0;
					
					chartContainer.addEventListener('touchstart', function(e) {
						startX = e.touches[0].pageX - chartContainer.offsetLeft;
						scrollLeft = chartContainer.scrollLeft;
					});

					chartContainer.addEventListener('touchmove', function(e) {
						e.preventDefault();
						var x = e.touches[0].pageX - chartContainer.offsetLeft;
						var walk = (x - startX) * 2;
						chartContainer.scrollLeft = scrollLeft - walk;
					});
				}
			}
		} else {
			// Show message if no data
			var ctx = document.getElementById('pageViewsChart');
			if (ctx) {
				ctx.getContext('2d').fillStyle = '#6c757d';
				ctx.getContext('2d').font = '14px Arial';
				ctx.getContext('2d').textAlign = 'center';
				ctx.getContext('2d').fillText('Belum ada data kunjungan', ctx.width / 2, ctx.height / 2);
			}
		}
	});

	// Page Views Stats Data
	var pageViewsStats = @json($pageViewsStats);

	function updatePageViewsStats(period) {
		// Update button states
		$('.btn-group button').removeClass('btn-primary').addClass('btn-outline-primary');
		$('.btn-group button').eq(['today', 'week', 'month', 'year'].indexOf(period)).removeClass('btn-outline-primary').addClass('btn-primary');

		// Update stats
		var stats = pageViewsStats[period];
		if (stats) {
			$('#total-views').text(stats.total_views || 0);
			$('#unique-visitors').text(stats.unique_visitors || 0);
			$('#today-views').text(pageViewsStats.today ? pageViewsStats.today.total_views || 0 : 0);
			$('#week-views').text(pageViewsStats.week ? pageViewsStats.week.total_views || 0 : 0);

			// Update top pages
			var topPagesHtml = '';
			if (stats.top_pages && stats.top_pages.length > 0) {
				stats.top_pages.forEach(function(page) {
					topPagesHtml += '<tr><td>' + (page.page_title || 'Halaman') + '</td><td><span class="badge bg-primary">' + (page.views || 0) + '</span></td></tr>';
				});
			} else {
				topPagesHtml = '<tr><td colspan="2" class="text-center text-muted">Belum ada data</td></tr>';
			}
			$('#top-pages').html(topPagesHtml);
		}
	}

	function updateTopPages(period) {
		// Update button states for top pages filter
		$('.btn-group-sm button').removeClass('btn-primary').addClass('btn-outline-primary');
		$('.btn-group-sm button').eq(['today', 'week', 'month', 'year'].indexOf(period)).removeClass('btn-outline-primary').addClass('btn-primary');

		// Show loading state
		$('#top-pages').html('<tr><td colspan="2" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>');

		// Make AJAX request
		$.ajax({
			url: '{{ route("admin.dashboard.top-pages") }}',
			method: 'GET',
			data: {
				period: period,
				limit: 10
			},
			success: function(response) {
				if (response.success) {
					var topPagesHtml = '';
					if (response.data && response.data.length > 0) {
						response.data.forEach(function(page) {
							topPagesHtml += '<tr><td>' + (page.page_title || 'Halaman') + '</td><td><span class="badge bg-primary">' + (page.views || 0) + '</span></td></tr>';
						});
					} else {
						topPagesHtml = '<tr><td colspan="2" class="text-center text-muted">Belum ada data</td></tr>';
					}
					$('#top-pages').html(topPagesHtml);
				} else {
					$('#top-pages').html('<tr><td colspan="2" class="text-center text-danger">Error loading data</td></tr>');
				}
			},
			error: function() {
				$('#top-pages').html('<tr><td colspan="2" class="text-center text-danger">Error loading data</td></tr>');
			}
		});
	}
</script>
@endpush