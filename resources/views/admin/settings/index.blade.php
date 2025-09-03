@extends('layouts.admin')

@section('title', 'Pengaturan SEO')

@section('content')
<div class="row">
    <div class="col-12 col-xl-12 grid-margin stretch-card">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                    <h6 class="card-title mb-0">Pengaturan SEO</h6>
                </div>
                <form method="POST" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site_title" class="form-label">Judul Website</label>
                                <input type="text" class="form-control @error('site_title') is-invalid @enderror" id="site_title" name="site_title" value="{{ old('site_title', $site_title) }}" placeholder="Portal Islam">
                                @error('site_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $meta_keywords) }}" placeholder="islam, berita, dakwah">
                                @error('meta_keywords')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="4" placeholder="Deskripsi singkat website">{{ old('meta_description', $meta_description) }}</textarea>
                                @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site_icon" class="form-label">Icon Website</label>
                                <input type="file" class="form-control @error('site_icon') is-invalid @enderror" id="site_icon" name="site_icon" accept="image/*">
                                @error('site_icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if($site_icon)
                                    <div class="mt-2">
                                        <img src="{{ $site_icon }}" alt="Site Icon" class="img-fluid rounded" style="max-height: 80px;">
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="favicon" class="form-label">Favicon</label>
                                <input type="file" class="form-control @error('favicon') is-invalid @enderror" id="favicon" name="favicon" accept="image/*">
                                @error('favicon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if($favicon)
                                    <div class="mt-2">
                                        <img src="{{ $favicon }}" alt="Favicon" class="img-fluid rounded" style="max-height: 40px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


