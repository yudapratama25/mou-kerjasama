@extends('layout.master')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800">Data Unit Kerja</h1>
    <p>Edit Data</p>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Unit Kerja</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6>Validasi Gagal</h6>
                            <ul class="mb-0 pl-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('unit.update', $unit->id) }}" method="post">
                        @csrf
                        @method('patch')
                        <div class="mb-3">
                            <label class="text-dark font-weight-bold">Nama Unit Kerja</label>
                            <input type="text" name="name" value="{{ $unit->name }}" class="form-control" placeholder="Masukan nama unit kerja" required>
                        </div>
                        <button class="btn btn-primary" type="submit">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection