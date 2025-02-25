@extends('layout.master')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800">Data Pengguna</h1>
    <p>Edit Data</p>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Pengguna</h6>
                </div>
                <div class="card-body">
                    <x-utility.validation-alert/>
                    <form action="{{ route('user.update', $user->id) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="text-dark font-weight-bold">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Masukan nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label class="text-dark font-weight-bold">Alamat Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Masukan alamat email" required>
                        </div>
                        <div class="mb-0">
                            <label class="text-dark font-weight-bold">Masa Aktif</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Dari</span>
                                        </div>
                                        <input type="date" name="from_date" value="{{ $user->from_date }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Sampai</span>
                                        </div>
                                        <input type="date" name="end_date" value="{{ $user->end_date }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <button class="btn btn-primary mr-3" type="submit">
                                    Simpan
                                </button>
                                <button class="btn btn-danger" type="button" id="btn-reset">
                                    Reset Password
                                </button>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route('user.index') }}" class="btn btn-secondary">
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
    <script>
        $('#btn-reset').on('click', function() {
            let isConfirm = confirm('Konfirmasi reset password ?');

            if (isConfirm == false) {
                return false;
            }

            $.post(`{{ route('user.reset-password') }}`, {user_id: `{{ $user->id }}`, _token: `{{ csrf_token() }}`},
                function (response) {
                    if (response.status == true) {
                        window.location.replace(`{{ route('user.index') }}`);
                    }
                }
            );
        });
    </script>
@endsection
