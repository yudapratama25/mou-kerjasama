@extends('layout.master')

@section('css')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://unpkg.com/dropzone@5.9.3/dist/min/dropzone.min.css" type="text/css"/>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800">Data Kerjasama</h1>
    <p>{{ $is_form_create ? 'Tambah' : 'Ubah'  }} Data</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form {{ $is_form_create ? 'Tambah' : 'Ubah'  }} Data Kerjasama</h6>
        </div>
        <div class="card-body">
            <form action="{{ ($is_form_create) ? route('mou.store') : route('mou.update', $mou->id) }}" method="post" enctype="multipart/form-data" id="form-mou">
                @csrf

                @if (!$is_form_create)
                @method('PATCH')
                @endif

                <x-utility.validation-alert/>

                @php
                    $tabs = [
                        'general'  => 'UMUM',
                        'mou'      => 'MOU',
                        'pks'      => 'PKS',
                        'document' => 'DOKUMEN'
                    ];

                    $mou_pks_status = ['HIDUP', 'MATI', 'DALAM PERPANJANGAN', 'TIDAK ADA'];
                @endphp

                <ul class="nav nav-pills nav-justified bg-light rounded">
                    @foreach ($tabs as $key => $tab)
                        <li class="nav-item">
                            <a class="nav-link {{ ($loop->first) ? 'active' : null }}" href="javascript:void(0);" data-toggle="pill" data-target="#tab-{{ $key }}">{{ $tab }}</a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content mt-4" id="pills-tabContent">
                    @foreach ($tabs as $key => $tab)
                        <div class="tab-pane fade {{ ($loop->first) ? 'show active' : null }}" id="tab-{{ $key }}" role="tabpanel">
                            @include('mou.forms.'.$key)
                        </div>
                    @endforeach
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center">
                    <p class="m-0">
                        (<span class="text-danger">*</span>) Wajib Diisi
                    </p>

                    <button class="btn btn-success w-25" type="button" id="btn-submit" style="display:none;">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://unpkg.com/dropzone@5.9.3/dist/min/dropzone.min.js"></script>
@vite('resources/js/mou-form.js')
@endsection
