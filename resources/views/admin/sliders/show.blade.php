@extends('layouts.admin')

@section('title', 'Detail Slider')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Detail Slider</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">Slider</a></li>
                        <li class="breadcrumb-item active">Detail</li>
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
                        <h5 class="card-title mb-0">Informasi Slider</h5>
                        <div class="btn-group">
                            <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Judul:</strong></td>
                                    <td>{{ $slider->title }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Deskripsi:</strong></td>
                                    <td>{{ $slider->description ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Link:</strong></td>
                                    <td>
                                        @if($slider->link)
                                            <a href="{{ $slider->link }}" target="_blank" class="text-primary">
                                                {{ $slider->link }} <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($slider->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Urutan:</strong></td>
                                    <td>{{ $slider->sort_order }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat:</strong></td>
                                    <td>{{ $slider->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Diupdate:</strong></td>
                                    <td>{{ $slider->updated_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h6 class="mb-3">Preview Gambar</h6>
                                @if($slider->image)
                                    <img src="{{ asset('storage/' . $slider->image) }}" 
                                         alt="{{ $slider->title }}" 
                                         class="img-fluid rounded shadow" 
                                         style="max-height: 300px;">
                                @else
                                    <div class="text-muted">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <p>Tidak ada gambar</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
