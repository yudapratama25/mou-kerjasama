@extends('layout.master')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800">Data Pengguna</h1>
    <p>Tambah Data</p>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Pengguna</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <h6>Validasi Gagal</h6>
                        <ul class="pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('user.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="text-dark font-weight-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukan nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label class="text-dark font-weight-bold">Alamat Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukan alamat email" required>
                        </div>
                        <div class="mb-0">
                            <label class="text-dark font-weight-bold">Masa Aktif</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Dari</span>
                                        </div>
                                        <input type="date" name="from_date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Sampai</span>
                                        </div>
                                        <input type="date" name="end_date" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <small class="text-danger d-block">
                            Password akun pengguna baru : 12345678
                        </small>
                        <div class="d-flex mt-3">
                            <button class="btn btn-primary mr-3" type="submit">
                                Simpan
                            </button>
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection