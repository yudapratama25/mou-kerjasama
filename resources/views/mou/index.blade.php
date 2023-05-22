@extends('layout.master')

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data MOU & PKS</h1>
        <div>
            <a href="{{ route('mou.create') }}" class="btn btn-sm btn-primary shadow-sm mr-2">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
            </a>
            <a href="{{ route('mou.export') }}" class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-file-excel text-white-50"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar MOU & PKS</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No.</th>
                            <th>Unit Kerja</th>
                            <th>Nomor Surat</th>
                            <th width="15%">Tanggal Terima</th>
                            <th width="30%">Perihal</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mous as $mou)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mou->unit->name }}</td>
                                <td>{{ $mou->letter_number }}</td>
                                <td>{{ ($mou->letter_receipt_date != null) ? \Carbon\Carbon::parse($mou->letter_receipt_date)->isoFormat('D MMMM Y') : '-' }}</td>
                                <td>{{ Str::limit($mou->regarding_letters, 100, '...') }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm mr-1" onclick="showMou(`{{ route('mou.show', $mou->id) }}`)">
                                        Lihat
                                    </button>
                                    <a href="{{ route('mou.edit', $mou->id) }}" class="btn btn-warning btn-sm mr-1">
                                        Edit
                                    </a>
                                    <button 
                                        type="button" 
                                        class="btn btn-danger btn-sm" 
                                        onclick="deleteData(`{{ $mou->id }}`, `{{ route('mou.destroy', $mou->id) }}`)">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="modal-mou" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Lihat Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-mou-body">
          ...
        </div>
        <div class="modal-footer">
          <a id="btn-export-pdf" href="#" target="_blank" class="btn btn-primary">Download PDF</a>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "ordering": false
            });
        });

        function showMou(url) {
            $('#modal-mou-body').html('');
            $('#btn-export-pdf').hide();
            $('#modal-mou').modal('show');

            let id = url.split('/').pop();

            $.get(url,
                function (response) {
                    console.log(response);
                    if (response.status == true) {
                        setTimeout(() => {
                            $('#modal-mou-body').html(response.data.html);
                            $('#btn-export-pdf').attr('href', `{{ url('dashboard/mou/export-pdf') }}/${id}`);
                            $('#btn-export-pdf').show();
                        }, 750);
                    }
                }
            );
        }
    </script>
@endsection