@extends('layouts.app')

@section('title')
    Beranda | PPK STIKES
@endsection

@section('content')
    @push('css-plugins')
        <link href="{{ asset('assets/destiny/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" media="all" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,300,500,700,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/destiny/assets/css/animate.css') }}"> <!-- Resource style -->
        <link rel="stylesheet" href="{{ asset('assets/destiny/assets/css/owl.carousel.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/destiny/assets/css/owl.theme.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/destiny/assets/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/destiny/assets/css/animsition.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/destiny/assets/css/ionicons.min.css') }}"> <!-- Resource style -->
        <link href="{{ asset('assets/destiny/assets/css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
    @endpush

    <div class="wrapper animsition" data-animsition-in-class="fade-in" data-animsition-in-duration="1000"
        data-animsition-out-class="fade-out" data-animsition-out-duration="1000">
        <div class="container">
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header page-scroll">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand page-scroll" href="{{ url('/') }}"><img src="{{ asset('assets/logo-stikes.svg') }}" height="70"
                                alt="STIKES" /></a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav nav-white">
                            @guest
                                <li><a href="{{ url('/') }}">Beranda</a></li>
                                <li><a href="{{ route('login') }}">Masuk</a></li>
                            @else
                                <li><a href="{{ url('/') }}">Beranda</a></li>
                                <li><a href="{{ url('/home') }}">Dashboard</a></li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @endguest

                        </ul>
                    </div>
                </div>
            </nav><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->

        <div class="main" id="main"><!-- Main Section-->
            <div class="jarallax">
                <div class="hero-section">
                    <div class="container">
                        <div class="hero-content txt-white d-flex justify-content-center align-items-center flex-column text-center" style="height: 100vh;">
                            <div class="col-md-12">
                                <h1 class="wow fadeInLeft display-3" data-wow-delay="0s">Sistem Pelaporan Penilaian Kepegawaian (PPK)</h1>
                                <p class="wow fadeInLeft" style="font-size: 1.3rem; margin-top: 10px;" data-wow-delay="0.1s">
                                    Sekolah Tinggi Ilmu Kesehatan Sambas
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="services-section text-center" id="services"><!-- Services section (small) with icons -->
                <div class="container">
                    <div class="col-md-8 col-md-offset-2 nopadding">
                        <div class="services-content">
                            <h1 class="wow fadeInUp">Destiny isn't A.I, its the result of human intelligence.</h1>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">
                                Ne homero petentium mel, eu pro putent persecuti. Id ius mutat gubergren, eros harum
                                hendrerit ex eos,
                                in quo vocibus inimicus gubergren.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <div class="services">
                            <div class="col-sm-4 wow fadeInUp" data-wow-delay="0.2s">
                                <div class="services-icon">
                                    <img src="{{ asset('destiny/assets/logos/icon1.png') }}" height="60" width="60" alt="Service" />
                                </div>
                                <div class="services-description">
                                    <h1>Highly Responsive</h1>
                                    <p>
                                        Id ius mutat gubergren, eros harum hendrerit ex eos,
                                        in quo vocibus inimicus gubergren.
                                        Experience, then believe.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="services-icon">
                                    <img class="icon-2" src="{{ asset('destiny/assets/logos/icon2.png') }}" height="60" width="60"
                                        alt="Service" />
                                </div>
                                <div class="services-description">
                                    <h1>Built-in Security</h1>
                                    <p>
                                        Id ius mutat gubergren, eros harum hendrerit ex eos,
                                        in quo vocibus inimicus gubergren.
                                        Experience, then believe.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeInUp" data-wow-delay="0.4s">
                                <div class="services-icon">
                                    <img class="icon-3" src="{{ asset('destiny/assets/logos/icon3.png') }}" height="60" width="60"
                                        alt="Service" />
                                </div>
                                <div class="services-description">
                                    <h1>Safety Locked</h1>
                                    <p>
                                        Id ius mutat gubergren, eros harum hendrerit ex eos,
                                        in quo vocibus inimicus gubergren.
                                        Experience, then believe.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="flex-features" id="website">
                <div class="container nopadding">

                    <div class="flex-split"><!-- Feature section with flex layout -->
                        <div class="f-right">
                            <div class="right-content wow fadeInUp" data-wow-delay="0s">
                                <h2>Aplikasi Web</h2>
                                <p>
                                    Sistem pencatatan data individu dan keluarga yang memungkinkan untuk mengidentifikasi dan menganalisis tingkat kemiskinan ekstrem
                                </p>
                                {{-- <ul>
                                    <li><i class="ion-android-checkbox-outline"></i>Import excel.</li>
                                    <li><i class="ion-android-checkbox-outline"></i>Repeat the same with another one.</li>
                                    <li><i class="ion-android-checkbox-outline"></i>Complete the list with the last.</li>
                                </ul> --}}
                                <a class="page-scroll btn btn-primary btn-action wow fadeInUp" data-wow-delay="0.2s" href="{{ route('login') }}">Masuk Sekarang</a>
                            </div>
                        </div>
                        <div class="f-left">
                            <div class="left-content wow fadeInUp" data-wow-delay="0.2s">
                                <img class="img-responsive" src="{{ asset('destiny/assets/images/feature_11.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature section with BG image -->
            <div class="features-section-2" id="android">
                <div class="container-fluid">
                    <div class="col-sm-6">
                        <div class="features-content wow fadeInLeft" data-wow-delay="0.2s">
                            <h2>Aplikasi Android</h2>
                            <h4>Membuat pendataan menjadi lebih mudah</h4>
                            {{-- <p>
                                Just get the code and sit tight, you'll witness its power and performance in lead
                                conversion.
                                Powerful and productive technology.
                            </p>
                            <p>
                                Experience, then believe. Just get the code and sit tight,
                                you'll witness its power and performance in lead conversion.
                            </p>
                            <p>
                                Just get the code and sit tight, you'll witness its power and performance in lead
                                conversion.
                            </p> --}}
                            <a class="page-scroll btn btn-primary btn-action wow fadeInUp" data-wow-delay="0.2s" href="#download">Download Aplikasi</a>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Counter Section -->
            <div class="counter-section">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-sm-6 col-xs-6">
                            <div class="counter-up">
                                <div class="counter-icon">
                                    <i class="ion-ios-people"></i>
                                </div>
                                <h3><span class="counter">{{ $pegawaiCount }}</span></h3>
                                <div class="counter-text">
                                    <h4>Pegawai</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="counter-up">
                                <div class="counter-icon">
                                    <i class="ion-bookmark"></i>
                                </div>
                                <h3><span class="counter">{{ $pekerjaanCount }}</span></h3>
                                <div class="counter-text">
                                    <h4>Pekerjaan</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Counter Section Ends -->

            <!-- Footer Section -->
            <div class="footer no-color">
                <div class="container">
                    <div class="col-md-12 text-center">
                        <div>
                            <img class="" src="{{ asset('assets/logo-stikes.svg') }}" height="110"
                            alt="" />
                            <div class="counter-text">
                                <h4>Sekolah Tinggi Ilmu Kesehatan Sambas</h4>
                            </div>
                        </div>
                        
                        <ul class="footer-menu" style="margin-top: 20px;">
                            <li><a href="{{ url('/') }}">Beranda</a></li>
                            <li><a href="#website">Aplikasi Web</a></li>
                            <li><a href="{{ route('login') }}">Masuk</a></li>
                        </ul>
                        <div class="footer-text">
                            <p>
                                Copyright © 2025 Sekolah Tinggi Ilmu Kesehatan Sambas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scroll To Top -->

            <a id="back-top" class="back-to-top page-scroll" href="#main">
                <i class="ion-ios-arrow-thin-up"></i>
            </a>

            <!-- Scroll To Top Ends-->

        </div><!-- Main Section -->
    </div><!-- Wrapper-->

    @push('javascript-plugins')
        <!-- Jquery and Js Plugins -->
        <script type="text/javascript" src="{{ asset('assets/destiny/assets/js/jquery-2.1.1.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/destiny/assets/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/destiny/assets/js/plugins.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/destiny/assets/js/menu.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/destiny/assets/js/custom.js') }}"></script>
    @endpush
@endsection
