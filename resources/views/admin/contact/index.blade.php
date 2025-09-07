@extends('layouts.admin')

@section('title', 'Pesan Kontak')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Pesan Kontak</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('contact') }}" target="_blank"><i data-feather="external-link" class="icon-sm me-2"></i> <span class="">Lihat Halaman Kontak</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Kelola pesan kontak yang dikirim dari halaman kontak website.</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<a href="{{ route('contact') }}" target="_blank" class="btn btn-secondary mb-3 mb-md-0">
							<i data-feather="external-link" class="icon-sm me-2"></i>
							Lihat Halaman Kontak
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

				<!-- Statistics -->
				<div class="row mb-4">
					<div class="col-md-4">
						<div class="card bg-primary text-white">
							<div class="card-body">
								<div class="d-flex justify-content-between">
									<div>
										<h4 class="mb-0">{{ $totalCount }}</h4>
										<p class="mb-0">Total Pesan</p>
									</div>
									<div class="align-self-center">
										<i data-feather="mail" class="icon-lg"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card bg-danger text-white">
							<div class="card-body">
								<div class="d-flex justify-content-between">
									<div>
										<h4 class="mb-0">{{ $unreadCount }}</h4>
										<p class="mb-0">Belum Dibaca</p>
									</div>
									<div class="align-self-center">
										<i data-feather="mail" class="icon-lg"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card bg-success text-white">
							<div class="card-body">
								<div class="d-flex justify-content-between">
									<div>
										<h4 class="mb-0">{{ $totalCount - $unreadCount }}</h4>
										<p class="mb-0">Sudah Dibaca</p>
									</div>
									<div class="align-self-center">
										<i data-feather="check-circle" class="icon-lg"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Messages List -->
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Status</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Subject</th>
								<th>Tanggal</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($messages as $message)
							<tr class="{{ $message->status === 'unread' ? 'table-warning' : '' }}">
								<td>
									<span class="badge {{ $message->status_badge_class }}">
										{{ $message->status_text }}
									</span>
								</td>
								<td>
									<strong>{{ $message->name }}</strong>
									@if($message->phone)
										<br><small class="text-muted">{{ $message->phone }}</small>
									@endif
								</td>
								<td>{{ $message->email }}</td>
								<td>{{ Str::limit($message->subject, 50) }}</td>
								<td>
									{{ $message->created_at->format('d M Y') }}
									<br><small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
								</td>
								<td>
									<div class="dropdown">
										<button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
											<i data-feather="more-vertical" class="icon-sm"></i>
										</button>
										<ul class="dropdown-menu">
											<li>
												<a class="dropdown-item" href="{{ route('admin.contact.show', $message) }}">
													<i data-feather="eye" class="icon-sm me-2"></i> Lihat Detail
												</a>
											</li>
											@if($message->status !== 'replied')
											<li>
												<form action="{{ route('admin.contact.mark-replied', $message) }}" method="POST" class="d-inline">
													@csrf
													@method('PATCH')
													<button type="submit" class="dropdown-item" onclick="return confirm('Tandai sebagai sudah dibalas?')">
														<i data-feather="check" class="icon-sm me-2"></i> Tandai Dibalas
													</button>
												</form>
											</li>
											@endif
											<li><hr class="dropdown-divider"></li>
											<li>
												<form action="{{ route('admin.contact.destroy', $message) }}" method="POST" class="d-inline">
													@csrf
													@method('DELETE')
													<button type="submit" class="dropdown-item text-danger" onclick="return confirm('Hapus pesan ini?')">
														<i data-feather="trash-2" class="icon-sm me-2"></i> Hapus
													</button>
												</form>
											</li>
										</ul>
									</div>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="6" class="text-center py-4">
									<div class="text-muted">
										<i data-feather="inbox" class="icon-lg mb-2"></i>
										<p class="mb-0">Belum ada pesan kontak</p>
									</div>
								</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>

				<!-- Pagination -->
				@if($messages->hasPages())
				<div class="d-flex justify-content-center mt-4">
					{{ $messages->links() }}
				</div>
				@endif
            </div>
        </div>
    </div>
</div>
@endsection