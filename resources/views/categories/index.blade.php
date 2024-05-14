@extends('layouts.app')

@section('title', 'Kategori')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Kategori</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <x-card>
                <x-slot name="header">
                    <div class="d-flex justify-content-between">
                        <h5 class="text-muted">Management Kategori</h5>
                        @can('Kategori Store')
                            <button onclick="addForm(`{{ route('category.store') }}`)" class="btn btn-sm btn-info"><i
                                    class="fas fa-plus-circle"></i>
                                Tambah Data
                            </button>
                        @endcan
                    </div>
                </x-slot>

                <x-table id="category" class="category" style="width: 100%">
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Status</th>
                        <th>Action</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @includeIf('categories.form')
@endsection

@include('categories.scripts')
