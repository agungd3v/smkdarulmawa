<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SMK Darul Mawa E-Learning') }} - @yield('profile')@yield('title')</title>
    <link rel="icon" href="{{ asset('assets/img/brand/favicon.png') }}" type="image/png">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/argon.css?v=1.2.0') }}" type="text/css">
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('css')
  </head>
  <body>
    <div id="app">
      <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
          <div class="sidenav-header align-items-center mt-5">
            <img src="{{ asset('assets/img/brand/favicon.png') }}" alt="">
            <a class="navbar-brand p-0" href="javascript:void(0)">
              <h3 class="text-bold">E-Learning</h3>
            </a>
          </div>
          <div class="navbar-inner">
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
              <ul class="navbar-nav">
                @if (Auth::user()->role === 'admin')
                  <li class="nav-item">
                    <a class="nav-link @yield('dashboard')" href="{{ route('admin.dashboard') }}">
                      <i class="ni ni-tv-2 text-primary"></i>
                      <span class="nav-link-text">Dashboard</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @yield('guru')" href="{{ route('admin.guru') }}">
                      <i class="ni ni-briefcase-24 text-success"></i>
                      <span class="nav-link-text">Data Guru</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @yield('siswa')" href="{{ route('admin.siswa') }}">
                      <i class="ni ni-hat-3 text-warning"></i>
                      <span class="nav-link-text">Data Siswa</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @yield('pelajaran')" href="{{ route('admin.pelajaran') }}">
                      <i class="ni ni-books text-danger"></i>
                      <span class="nav-link-text">Data Pelajaran</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @yield('jadwal')" href="{{ route('admin.jadwal') }}">
                      <i class="ni ni-calendar-grid-58 text-primary"></i>
                      <span class="nav-link-text">Data Jadwal</span>
                    </a>
                  </li>
                  {{-- <li class="nav-item">
                    <a class="nav-link @yield('absen')" href="{{ route('admin.absen') }}">
                      <i class="ni ni-check-bold text-info"></i>
                      <span class="nav-link-text">Data Absen</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @yield('nilai')" href="{{ route('admin.nilai') }}">
                      <i class="ni ni-paper-diploma text-default"></i>
                      <span class="nav-link-text">Data Nilai</span>
                    </a>
                  </li> --}}
                @endif
                @if (Auth::user()->role === 'guru')
                  <li class="nav-item">
                    <a class="nav-link @yield('dashboard')" href="{{ route('guru.dashboard') }}">
                      <i class="ni ni-tv-2 text-primary"></i>
                      <span class="nav-link-text">Dashboard</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @yield('jadwal')" href="{{ route('guru.jadwal') }}">
                      <i class="ni ni-calendar-grid-58 text-success"></i>
                      <span class="nav-link-text">Jadwal Mengajar</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @yield('absen')" href="{{ route('guru.absen') }}">
                      <i class="ni ni-check-bold text-warning"></i>
                      <span class="nav-link-text">Absen Siswa</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @yield('materi')" href="{{ route('guru.materi') }}">
                      <i class="ni ni-single-copy-04 text-info"></i>
                      <span class="nav-link-text">Materi Pelajaran</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @yield('tugas')" href="{{ route('guru.tugas') }}">
                      <i class="ni ni-vector text-danger"></i>
                      <span class="nav-link-text">Tugas</span>
                    </a>
                  </li>
                @endif
                @if (Auth::user()->role === 'siswa')
                  <li class="nav-item">
                    <a class="nav-link @yield('dashboard')" href="{{ route('siswa.dashboard') }}">
                      <i class="ni ni-tv-2 text-primary"></i>
                      <span class="nav-link-text">Dashboard</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @yield('jadwal')" href="{{ route('siswa.jadwal') }}">
                      <i class="ni ni-calendar-grid-58 text-warning"></i>
                      <span class="nav-link-text">Jadwal Pelajaran</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @yield('absen')" href="{{ route('siswa.absen') }}">
                      <i class="ni ni-check-bold text-info"></i>
                      <span class="nav-link-text">Absen Pelajaran</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @yield('materi')" href="{{ route('siswa.materi') }}">
                      <i class="ni ni-app text-success"></i>
                      <span class="nav-link-text">Materi Pelajaran</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @yield('tugas')" href="{{ route('siswa.tugas') }}">
                      <i class="ni ni-vector text-danger"></i>
                      <span class="nav-link-text">Tugas</span>
                    </a>
                  </li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </nav>
      <div class="main-content" id="panel">
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
          <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main"></form>
              <ul class="navbar-nav align-items-center  ml-md-auto ">
                <li class="nav-item d-xl-none">
                  <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                      <i class="sidenav-toggler-line"></i>
                      <i class="sidenav-toggler-line"></i>
                      <i class="sidenav-toggler-line"></i>
                    </div>
                  </div>
                </li>
              </ul>
              <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                <li class="nav-item dropdown">
                  <a class="nav-link pr-0" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                      <span class="avatar avatar-sm rounded-circle overflow-hidden">
                        <img alt="Image placeholder" src="{{ asset('assets/img/brand/favicon.png') }}" style="width: 36px; height: 36px">
                      </span>
                      <div class="media-body  ml-2  d-none d-lg-block">
                        <span class="mb-0 text-sm  font-weight-bold">{{ Auth::user()->name }}</span>
                      </div>
                    </div>
                  </a>
                  <div class="dropdown-menu  dropdown-menu-right">
                    <a href="{{ route('user.profile') }}" class="dropdown-item">
                      <i class="ni ni-single-02"></i>
                      <span>My profile</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="javascript:void(0)" class="dropdown-item" onclick="document.getElementById('logout-form').submit();">
                      <i class="ni ni-user-run"></i>
                      <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                    </form>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <div class="header bg-primary pb-6">
          <div class="container-fluid">
            <div class="header-body">
              <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                  <h6 class="h2 text-white d-inline-block mb-0">@yield('title')</h6>
                </div>
              </div>
              @yield('dashboard-card-info')
            </div>
          </div>
        </div>
        <div class="container-fluid mt--6">
          @yield('content')
        </div>
      </div>
    </div>
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
    <script src="{{ asset('assets/js/argon.js?v=1.2.0') }}"></script>
    @stack('js')
  </body>
</html>