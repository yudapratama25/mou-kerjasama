<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="http://si.ft.unmul.ac.id/image/unmul.ico" />

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    @yield('css')

</head>

<body id="page-top">

    @php
        $menu = Request::segment(2, 'dashboard');
    @endphp

    <!-- Page Wrapper -->
    <div id="wrapper" class="" style="height: 100vh;">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion position-fixed" style="z-index:1000;" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <div class="sidebar-heading mb-1">
                Pilih Tahun
            </div>

            <li class="nav-item">
                <div class="form-group px-3">
                    <select id="change-year" onchange="changeYear(this)" class="form-control" style="border: none;">
                        @foreach (session('years') as $year_id => $year)
                            <option value="{{ $year_id }}" @selected(session('selected_year_id') == $year_id)>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </li>

            <!-- Heading -->
            <div class="sidebar-heading">
                Menu Utama
            </div>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ ($menu == 'dashboard') ? 'active' : null }}">
                <a class="nav-link" href="{{ url('/dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item {{ ($menu == 'unit' || $menu == 'user' || $menu == 'log') ? 'active' : null }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Master Data</span>
                </a>
                <div id="collapseTwo" class="collapse {{ ($menu == 'unit' || $menu == 'user' || $menu == 'log') ? 'show' : null }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ ($menu == 'unit') ? 'active' : null }}" href="{{ route('unit.index') }}">Unit Kerja</a>
                        @if (Auth::user()->role !== "user")
                            <a class="collapse-item {{ ($menu == 'user') ? 'active' : null }}" href="{{ route('user.index') }}">Pengguna</a>
                            <a class="collapse-item {{ ($menu == 'log') ? 'active' : null }}" href="{{ route('log') }}">Log</a>
                        @endif
                    </div>
                </div>
            </li>

            <li class="nav-item {{ ($menu == 'mou' && request()->has('menu')) ? 'active' : null }}">
                <a class="nav-link" href="{{ route('mou.create', ['menu' => 'form-input']) }}">
                <i class="fas fa-fw fa-plus"></i>
                <span>Form Input</span></a>
            </li>

            <li class="nav-item {{ ($menu == 'mou' && !request()->has('menu')) ? 'active' : null }}">
                <a class="nav-link" href="{{ route('mou.index') }}">
                <i class="fas fa-fw fa-list"></i>
                <span>MOU & PKS</span></a>
            </li>

            <li class="nav-item {{ ($menu == 'profile') ? 'active' : null }}">
                <a class="nav-link" href="{{ route('user.profile') }}">
                <i class="fas fa-user-circle" style="font-size:1.1em;"></i>
                <span>Profil</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <div class="sidebar-card d-none d-lg-flex">
                <a class="btn btn-danger btn-sm w-100" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column position-relative" style="left: 14rem; overflow-x: hidden; width: calc(100% - 14rem); min-height: 100%;">

            <!-- Main Content -->
            <div id="content" class="pt-4">

                @yield('content')

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; {{ date('Y') }} MoU Kerja Sama</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Logout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" dibawah ini untuk mengakhiri sesi.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/') }}vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('/') }}vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('/') }}vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session()->has('success'))
        <script type="text/javascript">
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: `{!! session('success') !!}`,
                timer: 2500,
            });
        </script>
    @endif

    <script type="text/javascript">
        const _token = `{{ csrf_token() }}`;
        function deleteData(id, url) {
            Swal.fire({
                title: 'Yakin hapus data ?',
                text: "Data yang telah dihapus tidak dapat dipulihkan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Konfirmasi',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {id: id, _method: 'DELETE', _token: _token},
                        function (result) {
                            if (result.status == true) {
                                location.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Terjadi kesalahan',
                                });
                            }
                        }
                    );
                }
            });
        }

        function changeYear(element) {
            console.log(element.value);
            $.post(`{{ route('change-year') }}`, {_token: _token, year_id: element.value},
                function (response) {
                    if (response.status == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Pergantian tahun berhasil'
                        });
                        setTimeout(() => {
                            window.location.reload(true);
                        }, 1100);
                    } else {
                        alert("Terjadi kesalahan");
                    }
                }
            );
        }
    </script>

    @yield('js')
</body>

</html>
