<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('home') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/logo-stikes.svg') }}" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/logo-stikes.svg') }}" alt="" height="34"> <span class="logo-txt">STIKES</span>
                    </span>
                </a>

                <a href="{{ route('home') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/logo-stikes.svg') }}" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/logo-stikes.svg') }}" alt="" height="34"> <span class="logo-txt">STIKES</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">

            

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if (Auth::user())
                        <img class="rounded-circle header-profile-user" src="https://api.dicebear.com/5.x/identicon/svg?seed={{ Auth::user()->name }}"
                            alt="Header Avatar">
                        @if (Auth::user()->pegawai_id)
                            <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ Auth::user()->pegawai->nama_pegawai }}</span>
                        @else
                            <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ Auth::user()->name }}</span>
                        @endif
                    @endif
                    
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('pekerjaan-saya.index') }}"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Pekerjaan Saya</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        style="color: red">
                        <i class="mdi mdi-logout font-size-16 align-middle me-1" style="color: red"></i> Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>

<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                @guest
                    <li class="menu-title" data-key="t-menu">Menu</li>
                    <li>
                        <a href="{{ url('/') }}">
                            <i data-feather="home"></i>
                            <span class="badge rounded-pill bg-success-subtle text-success float-end">9+</span>
                            <span data-key="t-dashboard">Beranda</span>
                        </a>
                    </li>
                @else
                    <li class="menu-title" data-key="t-menu">Menu</li>
                    <li>
                        <a href="{{ route('home') }}">
                            <i data-feather="home"></i>
                            <span data-key="t-dashboard">Dashboard</span>
                        </a>
                    </li>

                    @role('Ketua')
                        <li>
                            <a href="{{ route('semesters.index') }}">
                                <i data-feather="users"></i>
                                {{-- <span class="badge rounded-pill bg-success-subtle text-success float-end">9+</span> --}}
                                <span data-key="t-chat">Pengaturan Semester</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('data-pegawai.index') }}">
                                <i data-feather="users"></i>
                                {{-- <span class="badge rounded-pill bg-success-subtle text-success float-end">9+</span> --}}
                                <span data-key="t-chat">Data Pegawai</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('pekerjaan-saya.index') }}">
                                <i data-feather="trello"></i>
                                <span data-key="t-chat">Pekerjaan Saya</span>
                            </a>
                        </li>
                    @endrole

                    @role('Pegawai')

                        <li>
                            <a href="{{ route('pekerjaan-saya.index') }}">
                                <i data-feather="trello"></i>
                                <span data-key="t-chat">Pekerjaan Saya</span>
                            </a>
                        </li>

                    @endrole

                @endguest

            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->