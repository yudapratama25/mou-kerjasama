@extends('layout.master')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Profile Akun</h1>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ubah Data Akun</h6>
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
                    <form action="{{ route('user.update-profile') }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="text-dark font-weight-bold">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" placeholder="Masukan nama lengkap" {{ (Auth::user()->role === "user") ? 'readonly disabled' : 'required' }}>
                        </div>
                        <div class="mb-3">
                            <label class="text-dark font-weight-bold">Alamat Email</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control" placeholder="Masukan alamat email" required>
                        </div>
                        <div class="mb-3">
                            <label class="text-dark font-weight-bold">Ubah Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Isi bila ingin merubah password">
                        </div>
                        <div class="mb-3">
                            <label class="text-dark font-weight-bold">Konfirmasi Ubah Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi perubahan password">
                        </div>
                        <button class="btn btn-primary mr-3" type="submit">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection