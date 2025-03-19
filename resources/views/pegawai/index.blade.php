@extends('layouts.app')

@section('title')
    Data Pegawai
@endsection

@section('content')
    @push('css-plugins')

        <!-- DataTables -->
        <link href="{{ asset('assets/admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css" />
        <link href="{{ asset('assets/admin/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="{{ asset('assets/admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
            rel="stylesheet" type="text/css" />
    @endpush

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- sidebar left -->
        @include('components.navbar')

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Data Pegawai ({{ $pegawais->count() }})</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Data Pegawai</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-all me-3 align-middle"></i><strong>Success</strong> -
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif ($message = Session::get('alert'))
                        <div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-block-helper me-3 align-middle"></i><strong>Danger</strong> -
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Pegawai</th>
                                            <th>Status Login</th>
                                            <th>Jumlah Pekerjaan</th>
                                            <th>Jumlah Poin</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pegawais as $key => $pegawai)
                                            <tr>
                                                <td>
                                                    <span>{{ ++$key }}</span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <a href="{{ route('pekerjaan-pegawai.show', $pegawai->id) }}">{{ $pegawai->nama_pegawai }}</a>
                                                    </span>
                                                </td>
                                                <td>
                                                    @foreach($pegawai->user as $user)
                                                        <span title="{{ $user->email }}">{{ $pegawai->nipy }}</span>
                                                    @endforeach
                                                </td>
                                                <td>{{ $pegawai->tugas_pegawai_count }}</td>
                                                <td>20</td>
                                                <td>Edit</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <!-- footer -->


    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    @push('javascript-plugins')

        <!-- Required datatable js -->
        <script src="{{ asset('assets/admin/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/admin/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

        <!-- Responsive examples -->
        <script src="{{ asset('assets/admin/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/admin/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

        <!-- Datatable init js -->
        <script src="{{ asset('assets/admin/js/pages/datatables.init.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

        <script>
            var clipboard = new ClipboardJS('#copyEmail');

            clipboard.on('success', function(e) {
                console.log('Email berhasil dicopy:', e.text);
            });

            clipboard.on('error', function(e) {
                console.error('Gagal menyalin email:', e.action);
            });
        </script>
    @endpush
@endsection
