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
    @endpush

    <body data-topbar="dark">
        
        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    
                    <!-- end col -->
                    <div class="col-xxl-7 col-lg-6 col-md-7">
                        <div class="auth-bg pt-md-5 p-4 d-flex">
                            <div class="bg-overlay"></div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xxl-5 col-lg-6 col-md-5">
                        <div class="auth-full-page-content d-flex p-sm-5 p-4">
                            <div class="w-100">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4 mb-md-5 text-center">
                                        <a href="{{ url('/') }}" class="d-block auth-logo">
                                            <img src="{{ asset('assets/logo-stikes.svg') }}" alt="" height="55"> <span class="logo-txt">STIKes Sambas</span>
                                        </a>
                                    </div>
                                    <div class="auth-content my-auto">
                                        <div class="text-center">
                                            <h5 class="mb-0">Selamat Datang!</h5>
                                            <p class="text-muted mt-2">Silahkan login untuk melanjutkan.</p>
                                        </div>
                                        <form class="mt-4 pt-2" method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <div class="form-floating form-floating-custom mb-4">
                                                <input id="input-email" class="form-control @error('email') is-invalid @enderror" type="email" required="" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                <label for="input-email">Email</label>
                                                <div class="form-floating-icon">
                                                   <i data-feather="users"></i>
                                                </div>
                                            </div>

                                            <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                                                <input id="password-input" class="form-control pe-5 @error('password') is-invalid @enderror" type="password" required="" placeholder="Password" name="password" required autocomplete="current-password">
                                                
                                                <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                                    <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                </button>
                                                <label for="input-password">Password</label>
                                                <div class="form-floating-icon">
                                                    <i data-feather="lock"></i>
                                                </div>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col">
                                                    <div class="form-check font-size-15">
                                                        <input class="custom-control-input" id="remember-check" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                        <label class="form-check-label font-size-13" for="remember-check">
                                                            Ingat saya
                                                        </label>
                                                    </div>  
                                                </div>
                                                
                                            </div>
                                            <div class="mb-3">
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Masuk</button>
                                            </div>
                                        </form>

                                        <div class="mt-4 pt-2 text-center">
                                            <div class="signin-other-title">
                                                <h5 class="font-size-14 mb-3 text-muted fw-medium">- Masuk dengan -</h5>
                                            </div>

                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('oauth.google') }}"
                                                        class="social-list-item bg-danger text-white border-danger">
                                                        <i class="mdi mdi-google"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="text-muted mb-0">
                                                @if (Route::has('password.request'))
                                                    <a class="text-muted" href="{{ route('password.request') }}">
                                                        {{ __('Lupa Password?') }}
                                                    </a>
                                                @endif
                                            </p>

                                            <p class="text-muted mt-3">
                                                Tidak punya akun? 
                                                <a href="https://wa.me/6289602461010?text=Saya%20ingin%20mendaftar%20di%20sistem%20PPK" target="_blank" class="text-primary fw-semibold"> 
                                                    Daftarkan akun 
                                                </a>
                                            </p>
                                        </div>
                                        
                                    </div>
                                    <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Sekolah Tinggi Ilmu Kesehatan Sambas . Crafted with <i class="mdi mdi-heart text-danger"></i> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
                    </div>

                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>

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
    @endpush
@endsection
