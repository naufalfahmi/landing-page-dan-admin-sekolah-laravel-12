@extends('layouts.admin')

@section('title', 'Detail Artikel')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Detail Artikel</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.articles.index') }}"><i data-feather="arrow-left" class="icon-sm me-2"></i> <span class="">Kembali</span></a>
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.articles.edit', $article) }}"><i data-feather="edit" class="icon-sm me-2"></i> <span class="">Edit</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Detail lengkap artikel Portal Islam.</p>
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
							<h2 class="mb-3">{{ $article->title }}</h2>
							<div class="d-flex align-items-center mb-3">
								<span class="badge bg-{{ $article->status === 'published' ? 'success' : 'warning' }} me-2">
									{{ $article->status === 'published' ? 'Terbit' : 'Draft' }}
								</span>
								<small class="text-muted">
									Oleh: {{ $article->author->name }} | 
									{{ $article->published_at ? $article->published_at->format('d M Y H:i') : 'Belum diterbitkan' }}
								</small>
							</div>
						</div>

						@if($article->image)
						<div class="mb-4">
							<img src="{{ $article->image }}" alt="{{ $article->title }}" class="img-fluid rounded">
						</div>
						@endif

						<div class="mb-4">
							<h5>Ringkasan</h5>
							<p class="text-muted">{{ $article->excerpt }}</p>
						</div>

						<div class="mb-4">
							<h5>Konten</h5>
							<div class="content">
								{!! $article->content !!}
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title">Informasi Artikel</h6>
								
								<div class="mb-3">
									<label class="form-label fw-bold">Penulis:</label>
									<p class="mb-0">{{ $article->author->name }}</p>
									<small class="text-muted">{{ $article->author->specialization }}</small>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Kategori:</label>
									<div>
										@foreach($article->categories as $category)
											<span class="badge bg-primary me-1 mb-1">{{ $category->name }}</span>
										@endforeach
									</div>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Status:</label>
									<p class="mb-0">
										<span class="badge bg-{{ $article->status === 'published' ? 'success' : 'warning' }}">
											{{ $article->status === 'published' ? 'Terbit' : 'Draft' }}
										</span>
									</p>
								</div>

								<div class="mb-3">
									<label class="form-label fw-bold">Tanggal Dibuat:</label>
									<p class="mb-0">{{ $article->created_at->format('d M Y H:i') }}</p>
								</div>

								@if($article->published_at)
								<div class="mb-3">
									<label class="form-label fw-bold">Tanggal Terbit:</label>
									<p class="mb-0">{{ $article->published_at->format('d M Y H:i') }}</p>
								</div>
								@endif

								<div class="mb-3">
									<label class="form-label fw-bold">Terakhir Diupdate:</label>
									<p class="mb-0">{{ $article->updated_at->format('d M Y H:i') }}</p>
								</div>

								<div class="d-grid gap-2">
									<a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-primary">
										<i data-feather="edit" class="icon-sm me-2"></i>
										Edit Artikel
									</a>
									<a href="{{ route('article.detail', $article->slug) }}" class="btn btn-outline-primary" target="_blank">
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

