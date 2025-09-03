@extends('layouts.admin')

@section('title', 'Detail Penulis')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Detail Penulis</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.authors.index') }}"><i data-feather="arrow-left" class="icon-sm me-2"></i> <span class="">Kembali</span></a>
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.authors.edit', $author) }}"><i data-feather="edit" class="icon-sm me-2"></i> <span class="">Edit</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Detail lengkap penulis Portal Islam.</p>
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
							<h2 class="mb-3">{{ $author->name }}</h2>
							<div class="d-flex align-items-center mb-3">
								<span class="badge bg-{{ $author->is_active ? 'success' : 'secondary' }} me-2">
									{{ $author->is_active ? 'Aktif' : 'Tidak Aktif' }}
								</span>
								<span class="badge bg-info me-2">{{ $author->specialization }}</span>
								<small class="text-muted">
									{{ $author->articles_count }} artikel
								</small>
							</div>
						</div>

						@if($author->bio)
						<div class="mb-4">
							<h5>Biografi</h5>
							<p class="text-muted">{{ $author->bio }}</p>
						</div>
						@endif

						@if($author->articles->count() > 0)
						<div class="mb-4">
							<h5>Artikel oleh Penulis Ini</h5>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Judul</th>
											<th>Kategori</th>
											<th>Status</th>
											<th>Tanggal</th>
										</tr>
									</thead>
									<tbody>
										@foreach($author->articles as $article)
										<tr>
											<td>
												<a href="{{ route('admin.articles.show', $article) }}" class="text-decoration-none">
													{{ Str::limit($article->title, 50) }}
												</a>
											</td>
											<td>
												@foreach($article->categories as $category)
													<span class="badge bg-primary me-1">{{ $category->name }}</span>
												@endforeach
											</td>
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
								<h6 class="card-title">Informasi Penulis</h6>
								<div class="d-flex align-items-center mb-3">
									@if(!empty($author->avatar))
										<img src="{{ $author->avatar }}" alt="avatar" class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
									@else
										@php
											$name = $author->name;
											$parts = preg_split('/\s+/', trim($name));
											$initials = '';
											foreach ($parts as $p) { $initials .= mb_strtoupper(mb_substr($p, 0, 1)); if (mb_strlen($initials) >= 2) break; }
										@endphp
										<div class="avatar-placeholder rounded-circle mx-auto d-flex align-items-center justify-content-center me-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 2rem; font-weight: bold;">
											{{ $initials }}
										</div>
									@endif
									<div>
										<h5 class="mb-0">{{ $author->name }}</h5>
										<small class="text-muted">{{ $author->email }}</small>
									</div>
								</div>
								
								<div class="mb-3">
									<label class="form-label fw-bold">Nama:</label>
									<p class="mb-0">{{ $author->name }}</p>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Email:</label>
									<p class="mb-0">{{ $author->email }}</p>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Slug:</label>
									<p class="mb-0">{{ $author->slug }}</p>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Spesialisasi:</label>
									<p class="mb-0">
										<span class="badge bg-info">{{ $author->specialization }}</span>
									</p>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Status:</label>
									<p class="mb-0">
										<span class="badge bg-{{ $author->is_active ? 'success' : 'secondary' }}">
											{{ $author->is_active ? 'Aktif' : 'Tidak Aktif' }}
										</span>
									</p>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Jumlah Artikel:</label>
									<p class="mb-0">{{ $author->articles_count }}</p>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Tanggal Dibuat:</label>
									<p class="mb-0">{{ $author->created_at->format('d M Y H:i') }}</p>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Terakhir Diupdate:</label>
									<p class="mb-0">{{ $author->updated_at->format('d M Y H:i') }}</p>
								</div>

								<div class="d-grid gap-2">
									<a href="{{ route('admin.authors.edit', $author) }}" class="btn btn-primary">
										<i data-feather="edit" class="icon-sm me-2"></i>
										Edit Penulis
									</a>
									<a href="{{ route('author', $author->slug) }}" class="btn btn-outline-primary" target="_blank">
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
