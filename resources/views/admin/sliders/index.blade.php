@extends('layouts.admin')

@section('title', 'Kelola Slider')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Kelola Slider</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Slider</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Daftar Slider</h5>
                        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Slider
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($sliders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
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
                                    @foreach($sliders as $index => $slider)
                                    <tr>
                                        <td>{{ $sliders->firstItem() + $index }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $slider->image) }}" 
                                                 alt="{{ $slider->title }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 80px; height: 60px; object-fit: cover;">
                                        </td>
                                        <td>{{ $slider->title }}</td>
                                        <td>{{ Str::limit($slider->description, 50) }}</td>
                                        <td>
                                            @if($slider->link)
                                                <a href="{{ $slider->link }}" target="_blank" class="text-primary">
                                                    <i class="fas fa-external-link-alt"></i>
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
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.sliders.show', $slider) }}" 
                                                   class="btn btn-sm btn-info" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.sliders.edit', $slider) }}" 
                                                   class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.sliders.destroy', $slider) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus slider ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($sliders->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $sliders->links() }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada slider</h5>
                            <p class="text-muted">Klik tombol "Tambah Slider" untuk menambahkan slider pertama.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

