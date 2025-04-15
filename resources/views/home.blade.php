@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    @push('css-plugins')
    <!-- plugin css -->
    <link href="{{ asset('assets/admin/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/preloader.min.css') }}" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">

        <!-- DataTables -->
        <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css" />
    @endpush

    <body data-topbar="dark">

        <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">


            @include('components.navbar')

            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                <strong>Success!</strong> {{ $message }}.
                            </div>
                        @endif

                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                @foreach ($errors->all() as $error)
                                    <strong>{{ $error }}</strong><br>
                                @endforeach
                            </div>
                        @endif

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Dashboard</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active"><a href="javascript: void(0);">Dashboard</a>
                                            </li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        @role('Ketua')
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-17 mb-2">Selamat Datang
                                                    {{ Auth::user()->name }}</p>
                                                <p class="text-truncate font-size-14 mb-2">Email: {{ Auth::user()->email }}
                                                </p>
                                                <p class="text-truncate font-size-14 mb-2">Bergabung Pada:
                                                    {{ Auth::user()->created_at }}</p>
                                                <p class="text-truncate font-size-14 mb-2">Anda masuk sebagai:
                                                    {{ Auth::user()->getRoleNames()->first() }}</p>

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-success btn-sm mt-3"
                                                    data-bs-toggle="modal" data-bs-target="#userModal">
                                                    <i class="fas fa-user"></i> Ubah Profil Saya
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="userModal" tabindex="-1"
                                                    aria-labelledby="userModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="userModalLabel">Ubah Profil Saya
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <form action="{{ route('update.profile') }}" method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="name" class="form-label">Nama <span
                                                                                style="color: red">*</span></label>
                                                                        <input type="text"
                                                                            class="form-control @error('name') is-invalid @enderror"
                                                                            id="name" name="name"
                                                                            value="{{ old('name', Auth::user()->name) }}"
                                                                            required>

                                                                        @error('name')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="email" class="form-label">Email <span
                                                                                style="color: red">*</span></label>
                                                                        <input type="email"
                                                                            class="form-control @error('email') is-invalid @enderror"
                                                                            id="email" name="email"
                                                                            value="{{ old('email', Auth::user()->email) }}"
                                                                            required>

                                                                        @error('email')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>

                                                                    <p>Keterangan: <span style="color: red">*</span>) wajib
                                                                        diisi</p>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Tutup</button>
                                                                        <button type="submit" class="btn btn-primary">Simpan
                                                                            Data</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-info btn-sm mt-3 mx-1"
                                                    data-bs-toggle="modal" data-bs-target="#passwordModal">
                                                    <i class="fas fa-unlock-alt"></i> Ubah Password
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="passwordModal" tabindex="-1"
                                                    aria-labelledby="passwordModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="passwordModalLabel">Ubah Password
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <form action="{{ route('update.password') }}" method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="password" class="form-label">Password Baru
                                                                            <span style="color: red">*</span></label>
                                                                        <input type="password"
                                                                            class="form-control @error('password') is-invalid @enderror"
                                                                            id="password" name="password" required>

                                                                        @error('password')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="password_confirmation"
                                                                            class="form-label">Konfirmasi Password Baru <span
                                                                                style="color: red">*</span></label>
                                                                        <input type="password"
                                                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                                                            id="password_confirmation"
                                                                            name="password_confirmation" required>

                                                                        @error('password_confirmation')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>

                                                                    <p>Keterangan: <span style="color: red">*</span>) wajib
                                                                        diisi</p>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Tutup</button>
                                                                        <button type="submit" class="btn btn-primary">Ubah
                                                                            Password</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div><!-- end cardbody -->
                                    </div> <!-- end card -->
                                </div><!-- end col-->
                            </div>
                            <!-- end row-->
                        @endrole


                        @role('Pegawai')
                            @if (Auth::user()->pegawai_id)
                                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap">
                                                    <div class="flex-grow-1">
                                                        <p class="font-size-17 mb-2" style="word-break: break-word;">
                                                            <strong>Selamat Datang, {{ Auth::user()->pegawai->nama_pegawai }}</strong>
                                                        </p>
                                                        <p class="font-size-14 mb-2">Email: {{ Auth::user()->email }}</p>
                                                        <p class="font-size-14 mb-2">NIPY: {{ Auth::user()->pegawai->nipy }}</p>
                                
                                                        {{-- <h4 class="mb-2">{{ $totalPoinSaya }}</h4>
                                                        <p class="text-muted mb-0">Poin Saya</p> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            @else
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong>Info!</strong> Harap isikan NIPY untuk melakukan verifikasi data anda.
                                </div>

                                <form action="{{ route('validate-nipy') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                            disabled required>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="nipy" class="form-label">NIPY <span
                                                style="color: red">*</span></label>
                                        <input type="number" class="form-control @error('nipy') is-invalid @enderror"
                                            id="nipy" name="nipy" value="{{ old('nipy') }}" required>

                                        @error('nipy')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>

                                    <button type="submit" class="btn btn-primary">Verifikasi Data</button>
                                </form>
                            @endif
                        @endrole

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                {{-- @include('components.footer') --}}

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

    </body>


    @push('javascript-plugins')
    <script src="{{ asset('assets/admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/feather-icons/feather.min.js') }}"></script>
    <!-- pace js -->
    <script src="{{ asset('assets/admin/libs/pace-js/pace.min.js') }}"></script>

        
    <!-- apexcharts -->
    <script src="{{ asset('assets/admin/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Plugins js-->
    <script src="{{ asset('assets/admin/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script>

    <script src="{{ asset('assets/admin/js/pages/allchart.js') }}"></script>
    <!-- dashboard init -->
    <script src="{{ asset('assets/admin/js/pages/dashboard.init.js') }}"></script>

    <script src="{{ asset('assets/admin/js/app.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>

        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

        <!-- Responsive examples -->
        <script src="≈{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

        <!-- Datatable init js -->
        <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
@endsection
