@extends('layouts.admin')

@section('title', 'Detail Pesan Kontak')

@section('content')
<div class="row">
	<div class="col-12 col-xl-12 grid-margin stretch-card">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
					<h6 class="card-title mb-0">Detail Pesan Kontak</h6>
					<div class="dropdown">
						<button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
							<a class="dropdown-item d-flex align-items-center" href="{{ route('admin.contact.index') }}"><i data-feather="arrow-left" class="icon-sm me-2"></i> <span class="">Kembali ke Daftar</span></a>
						</div>
					</div>
				</div>
				<div class="row align-items-start">
					<div class="col-md-7">
						<p class="text-muted tx-13 mb-3 mb-md-0">Detail lengkap pesan kontak yang dikirim dari website.</p>
					</div>
					<div class="col-md-5 d-flex justify-content-md-end">
						<a href="{{ route('admin.contact.index') }}" class="btn btn-secondary mb-3 mb-md-0">
							<i data-feather="arrow-left" class="icon-sm me-2"></i>
							Kembali ke Daftar
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

				<!-- Message Header -->
				<div class="row mb-4">
					<div class="col-12">
						<div class="d-flex justify-content-between align-items-start">
							<div>
								<h4 class="mb-1">{{ $contact->subject }}</h4>
								<div class="d-flex align-items-center gap-3">
									<span class="badge {{ $contact->status_badge_class }}">{{ $contact->status_text }}</span>
									<small class="text-muted">
										<i data-feather="clock" class="icon-sm me-1"></i>
										{{ $contact->created_at->format('d M Y, H:i') }}
									</small>
								</div>
							</div>
							<div class="dropdown">
								<button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
									<i data-feather="more-vertical" class="icon-sm"></i>
								</button>
								<ul class="dropdown-menu">
									@if($contact->status !== 'replied')
									<li>
										<form action="{{ route('admin.contact.mark-replied', $contact) }}" method="POST" class="d-inline">
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
										<form action="{{ route('admin.contact.destroy', $contact) }}" method="POST" class="d-inline">
											@csrf
											@method('DELETE')
											<button type="submit" class="dropdown-item text-danger" onclick="return confirm('Hapus pesan ini?')">
												<i data-feather="trash-2" class="icon-sm me-2"></i> Hapus
											</button>
										</form>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<!-- Sender Information -->
				<div class="row mb-4">
					<div class="col-md-6">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title">
									<i data-feather="user" class="icon-sm me-2"></i>
									Informasi Pengirim
								</h6>
								<div class="row">
									<div class="col-12">
										<p class="mb-2">
											<strong>Nama:</strong> {{ $contact->name }}
										</p>
										<p class="mb-2">
											<strong>Email:</strong> 
											<a href="mailto:{{ $contact->email }}" class="text-primary">{{ $contact->email }}</a>
										</p>
										@if($contact->phone)
										<p class="mb-0">
											<strong>Telepon:</strong> 
											<a href="tel:{{ $contact->phone }}" class="text-primary">{{ $contact->phone }}</a>
										</p>
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title">
									<i data-feather="info" class="icon-sm me-2"></i>
									Informasi Pesan
								</h6>
								<div class="row">
									<div class="col-12">
										<p class="mb-2">
											<strong>Status:</strong> 
											<span class="badge {{ $contact->status_badge_class }}">{{ $contact->status_text }}</span>
										</p>
										<p class="mb-2">
											<strong>Dikirim:</strong> {{ $contact->created_at->format('d M Y, H:i') }}
										</p>
										@if($contact->read_at)
										<p class="mb-0">
											<strong>Dibaca:</strong> {{ $contact->read_at->format('d M Y, H:i') }}
										</p>
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Message Content -->
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title">
									<i data-feather="message-square" class="icon-sm me-2"></i>
									Isi Pesan
								</h6>
								<div class="message-content">
									{!! nl2br(e($contact->message)) !!}
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Action Buttons -->
				<div class="row mt-4">
					<div class="col-12">
						<div class="d-flex justify-content-between">
							<a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">
								<i data-feather="arrow-left" class="icon-sm me-2"></i>
								Kembali ke Daftar
							</a>
							<div class="d-flex gap-2">
								@if($contact->status !== 'replied')
								<form action="{{ route('admin.contact.mark-replied', $contact) }}" method="POST" class="d-inline">
									@csrf
									@method('PATCH')
									<button type="submit" class="btn btn-success" onclick="return confirm('Tandai sebagai sudah dibalas?')">
										<i data-feather="check" class="icon-sm me-2"></i>
										Tandai Dibalas
									</button>
								</form>
								@endif
								<a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-primary">
									<i data-feather="mail" class="icon-sm me-2"></i>
									Balas Email
								</a>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-css')
<style>
.message-content {
	background-color: #f8f9fa;
	border: 1px solid #e9ecef;
	border-radius: 0.375rem;
	padding: 1rem;
	white-space: pre-wrap;
	word-wrap: break-word;
}
</style>
@endpush
