@extends('layouts.admin')

@section('title', 'Detail Kategori')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Detail Kategori</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.categories.index') }}"><i data-feather="arrow-left" class="icon-sm me-2"></i> <span class="">Kembali</span></a>
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.categories.edit', $category) }}"><i data-feather="edit" class="icon-sm me-2"></i> <span class="">Edit</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Detail lengkap kategori SMPIT Al-Itqon.</p>
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
							<h2 class="mb-3">{{ $category->name }}</h2>
							<div class="d-flex align-items-center mb-3">
								<span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }} me-2">
									{{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}
								</span>
								<small class="text-muted">
									{{ $category->articles_count }} artikel
								</small>
							</div>
						</div>

						@if($category->description)
						<div class="mb-4">
							<h5>Deskripsi</h5>
							<p class="text-muted">{{ $category->description }}</p>
						</div>
						@endif

						@if($category->articles->count() > 0)
						<div class="mb-4">
							<h5>Artikel dalam Kategori Ini</h5>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Judul</th>
											<th>Penulis</th>
											<th>Status</th>
											<th>Tanggal</th>
										</tr>
									</thead>
									<tbody>
										@foreach($category->articles as $article)
										<tr>
											<td>
												<a href="{{ route('admin.articles.show', $article) }}" class="text-decoration-none">
													{{ Str::limit($article->title, 50) }}
												</a>
											</td>
											<td>{{ $article->author->name }}</td>
											<td>
												<span class="badge bg-{{ $article->status === 'published' ? 'success' : 'warning' }}">
													{{ $article->status === 'published' ? 'Terbit' : 'Draft' }}
												</span>
											</td>
											<td>{{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						@endif
					</div>

					<div class="col-md-4">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title">Informasi Kategori</h6>
								
								<div class="mb-3">
									<label class="form-label fw-bold">Nama:</label>
									<p class="mb-0">{{ $category->name }}</p>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Slug:</label>
									<p class="mb-0">{{ $category->slug }}</p>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Status:</label>
									<p class="mb-0">
										<span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
											{{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}
										</span>
									</p>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Jumlah Artikel:</label>
									<p class="mb-0">{{ $category->articles_count }}</p>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Tanggal Dibuat:</label>
									<p class="mb-0">{{ $category->created_at->format('d M Y H:i') }}</p>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Terakhir Diupdate:</label>
									<p class="mb-0">{{ $category->updated_at->format('d M Y H:i') }}</p>
								</div>

								<div class="d-grid gap-2">
									<a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
										<i data-feather="edit" class="icon-sm me-2"></i>
										Edit Kategori
									</a>
									<a href="{{ route('category.show', $category->slug) }}" class="btn btn-outline-primary" target="_blank">
										<i data-feather="external-link" class="icon-sm me-2"></i>
										Lihat di Website
									</a>
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
