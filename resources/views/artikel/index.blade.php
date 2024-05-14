@extends('layouts.app')

@section('title', 'Artikel')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Artikel</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="header">
                    <h5 class="text-muted">Filter Data Artikel</h5>
                </x-slot>
                <div class="d-flex justify-content-between">
                    <div class="form-group">
                        <label for="status2">Status</label>
                        <select name="status" id="status" class="custom-select">
                            <option value="" selected>Semua</option>
                            <option value="publish" {{ request('status') == 'publish' ? 'selected' : '' }}>Publish</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </option>
                        </select>
                    </div>

                    <div class="d-flex">
                        <div class="form-group mx-3">
                            <label for="start_date">Tanggal Awal</label>
                            <div class="input-group datepicker" id="start_date" data-target-input="nearest">
                                <input type="text" name="start_date" class="form-control datetimepicker-input"
                                    data-target="#start_date" data-toggle="datetimepicker" />
                                <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir</label>
                            <div class="input-group datepicker" id="end_date" data-target-input="nearest">
                                <input type="text" name="end_date" class="form-control datetimepicker-input"
                                    data-target="#end_date" data-toggle="datetimepicker" />
                                <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <x-card>
                <x-slot name="header">
                    <div class="d-flex justify-content-between">
                        <h5 class="text-muted">Management Artikel</h5>
                        @can('Artikel Store')
                            <button onclick="addForm(`{{ route('articles.store') }}`)" class="btn btn-sm btn-info"><i
                                    class="fas fa-plus-circle"></i>
                                Tambah Data
                            </button>
                        @endcan
                    </div>
                </x-slot>

                <x-table id="articles" class="articles" style="width: 100%">
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Penulis</th>
                        <th>Tanggal Publish</th>
                        <th>Action</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @includeIf('artikel.form')
@endsection

@include('artikel.scripts')
