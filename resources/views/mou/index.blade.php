@extends('layout.master')

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        table {
            font-size: .7em;
        }
    </style>
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

            <div class="btn-group mr-2" role="group">
                <button type="button" class="btn btn-sm btn-success dropdown-toggle shadow-sm" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-excel text-white-50"></i> Export Excel
                </button>
                <div class="dropdown-menu">
                    <button type="button" onclick="exportExcel(this)" class="dropdown-item" data-href="{{ route('mou.export', ['is_minimalis' => false]) }}">
                        Export Lengkap
                    </button>
                    <button type="button" onclick="exportExcel(this)" class="dropdown-item" data-href="{{ route('mou.export', ['is_minimalis' => true]) }}">
                        Export Singkat
                    </button>
                    <button type="button" onclick="exportExcel(this)" class="dropdown-item" data-href="{{ route('mou.export', ['is_minimalis' => true, 'is_rekapitulasi' => true]) }}">
                        Export Rekapitulasi
                    </button>
                </div>
            </div>

            @if (Auth::user()->role == 'administrator')
            <a href="{{ route('backup') }}" class="btn btn-sm btn-info shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Backup Data
            </a>
            @endif
        </div>
    </div>

    <!-- Statistik -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Perhitungan</h6>
            <small class="m-0">
                Berdasarkan hasil pencarian pada tabel
            </small>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-xl-3 col-md-6">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Data</div>
                                    <div id="total-data" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-cubes fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Nilai Kontrak</div>
                                    <div id="total-contract-value" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="text-gray-300" style="font-size: 1.6em;">Rp</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Total Transfer Bank</div>
                                    <div id="total-bank-transfer-proceeds" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="text-gray-300" style="font-size: 1.6em;">Rp</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Total Selisih</div>
                                    <div id="total-nominal-difference" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="text-gray-300" style="font-size: 1.6em;">Rp</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar MOU & PKS</h6>
        </div>
        <div class="card-body">

            <div id="filter">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="unit_id">Unit Kerja</label>
                            <select name="unit_id" id="unit-id" class="form-control">
                                <option value="0">Semua</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>No. Surat</label>
                            <input type="text" name="letter_number" id="search-letter-number" class="form-control" placeholder="No. Surat">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Tanggal Terima</label>
                            <input type="date" name="letter_receipt_date" id="search-letter-receipt-date" class="form-control" placeholder="Tanggal Terima Surat">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Perihal Surat</label>
                            <input type="input" name="regarding_letters" id="search-regarding-letters" class="form-control" placeholder="Perihal Surat">
                        </div>
                    </div>
                    <div class="col-md-2 pb-3">
                        <div class="h-100 d-flex align-items-end">
                            <button type="button" id="btn-search" class="btn px-3 btn-primary mr-3">Cari</button>
                            <button type="button" id="btn-reset" class="btn btn-danger">Reset</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" cellspacing="0">
                    <thead>
                        <tr style="color:black;">
                            <th width="5%">No.</th>
                            <th>Unit Kerja</th>
                            <th>Nomor Surat</th>
                            <th width="10%">Tanggal Terima</th>
                            <th width="13%">Nilai Kontrak</th>
                            <th width="13%">Hasil Transfer Bank</th>
                            <th width="13%">Selisih</th>
                            <th width="13%">#</th>
                        </tr>
                    </thead>
                    <tbody>
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
    <script type="text/javascript">

        const searchUnitId = $('#unit-id');
        const searchLetterNumber = $('#search-letter-number');
        const searchLetterReceiptDate = $('#search-letter-receipt-date');
        const searchRegardingLetters = $('#search-regarding-letters');

        $(document).ready(function() {
            let dataTable = $(`#dataTable`).DataTable({
                pageLength: 50,
                lengthMenu: [50, 75, 100],
                ordering: false,
                searching: false,
                searchDelay: 1100,
                info: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('mou.index') }}`,
                    data: function (d) {
                        d.unit_id             = searchUnitId.val();
                        d.letter_number       = searchLetterNumber.val().trim();
                        d.letter_receipt_date = searchLetterReceiptDate.val().trim();
                        d.regarding_letters   = searchRegardingLetters.val().trim();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'unit.name', name: 'unit_name', },
                    { data: 'letter_number', name: 'letter_number' },
                    { data: 'letter_receipt_date', name: 'letter_receipt_date' },
                    { data: 'pks_contract_value', name: 'pks_contract_value' },
                    { data: 'bank_transfer_proceeds', name: 'bank_transfer_proceeds' },
                    { data: 'nominal_difference', name: 'nominal_difference' },
                    { data: 'action', name: 'action', className: 'dt-control' },
                ],
                language: {
                    info: 'Menampilkan _START_ sampai _END_ dari total _TOTAL_ data',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    paginate: {
                        "first":      "Awal",
                        "last":       "Akhir",
                        "next":       ">",
                        "previous":   "<"
                    },
                },
                dom: 'rit<"row align-items-center"<"col-md-3"l><"col-md-9"p>>'
            });

            $('#dataTable tbody').on('click', 'td.dt-control button.show-extra', function (e) {
                var tr = $(this).closest('tr');
                var row = dataTable.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                }
                else {
                    // Open this row
                    row.child(showExtra(row.data())).show();
                }
            });

            $('#btn-search').on('click', function(e) {
                dataTable.draw();
            });

            $('#btn-reset').on('click', function(e) {
                searchUnitId.val('0');
                searchLetterNumber.val('');
                searchLetterReceiptDate.val('');
                searchRegardingLetters.val('');

                dataTable.draw();
            });

            dataTable.on('draw', function () {
                getCalculation();
            });
        });

        function getCalculation() {
            $.get(`{{ route('mou.calculation') }}`,
                {
                    unit_id: searchUnitId.val(),
                    letter_number: searchLetterNumber.val().trim(),
                    letter_receipt_date: searchLetterReceiptDate.val().trim(),
                    regarding_letters: searchRegardingLetters.val().trim()
                }).done(
                    function (response) {
                        if (response.status == true) {
                            $('#total-data').html(response.data.total_data);
                            $('#total-contract-value').html(response.data.pks_contract_value);
                            $('#total-bank-transfer-proceeds').html(response.data.bank_transfer_proceeds);
                            $('#total-nominal-difference').html(response.data.nominal_difference);
                        }
                    }
                ).fail(
                    function (response) {
                        console.log(response);
                    }
                );
        }

        function showExtra(data) {
            return `<table class="table table-bordered" style="font-size: 1em;">
                        <tr>
                            <td class="font-weight-bold" width="13%">Perihal</td>
                            <td>${data.regarding_letters}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold" width="13%">Status MOU</td>
                            <td>${data.mou_status}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold" width="13%">Status PKS</td>
                            <td>${data.pks_status}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold" width="13%">Nama Mitra</td>
                            <td>${data.partner_name}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold" width="13%">Nama Kegiatan</td>
                            <td>${data.pks_regarding}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold" width="13%">Kriteria Kerjasama</td>
                            <td>${data.cooperation_criteria ?? '-'}</td>
                        </tr>
                    </table>`;
        }

        function showMou(url) {
            $('#modal-mou-body').html('');
            $('#btn-export-pdf').hide();
            $('#modal-mou').modal('show');

            let id = url.split('/').pop();

            $.get(url,
                function (response) {
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

        function exportExcel(e) {
            let href = e.getAttribute('data-href') + '&';

            href += `unit_id=${searchUnitId.val()}&`;
            href += `letter_number=${searchLetterNumber.val().trim()}&`;
            href += `letter_receipt_date=${searchLetterReceiptDate.val().trim()}&`;
            href += `regarding_letters=${searchRegardingLetters.val().trim()}`;

            window.location.href = href;
        }
    </script>
@endsection
