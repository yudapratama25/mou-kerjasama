@extends('layout.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Riwayat Aktivitas Pengguna</h1>
            
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pengguna</th>
                                    <th>Aktivitas</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $number = ($logs->currentPage() - 1) * $logs->perPage();
                                @endphp
                                @forelse ($logs as $log)
                                    <tr>
                                        <td>{{ ++$number }}</td>
                                        <td>{{ $log->user->name }}</td>
                                        <td>{{ $log->action }}</td>
                                        <td>{{ $log->created_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada aktivitas</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
      
    </div>
    <!-- /.container-fluid -->
@endsection