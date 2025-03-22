
<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
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
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                    <span class="avatar avatar-sm rounded-circle">
                    <i class="ni ni-single-02"></i>
                  </span>
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">{{Auth::user()->name}}</span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Selamat Datang!</h6>
                </div>
                <a href="{{ asset('web/user/update/'.Auth::user()->id) }}" class="dropdown-item">
                  <i class="ni ni-single-02"></i>
                  <span>Change Password</span>
                </a>
                <div class="dropdown-divider"></div>
                <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            <i class="ni ni-user-run"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <main class="main-content border-radius-lg header bg-primary pb-1">
      <div class="container-fluid py-4">
      @if(\Auth::user()->google2fa_enabled == 0)
          <div class="row">
            <div class="col-xl-12">
              <div class="card alert-warning bg-gradient-warning">
                <div class="card-body">
                  Fitur <b>Multi-Factor Authentication</b> belum aktif.<br>
                  Anda dapat mengaktifkan Fitur MFA untuk menambah lapisan keamanan.<br>
                  <p>Pastikan Google Authenticator atau aplikasi sejenisnya telah terinstall pada perangkat HP Anda.</p>
                  <p style="">(Jika Anda klik tombol berikut ini, harus menyelesaikannya. <b>Pastikan Anda telah siap untuk aktivasi</b>)</p>
                  <a class="btn btn-lg btn-info bg-gradient-warning mt-4 mb-0 text-white" href="{{asset('mfa/enable')}}">Aktifasi Fitur MFA</a>
                </div>
              </div>
            </div>
          </div>
          @endif
          <div class="row">
            <div class="col-xl-12">
              <div id="alert">
                @include('includes.alert')
              </div>
            </div>
          </div>
      </div>
    </main>
  <div class="header bg-primary pb-6">
    <div class="container-fluid">
      <div class="header-body">
        <div class="row align-items-center py-4">
          <div class="col-lg-6 col-7">
            <h6 class="h2 text-white d-inline-block mb-0"> {{$page}} </h6>
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
              <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ asset('/home') }}"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">{{$judul}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $subjudul }}</li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-6 col-5 text-right">
          {!! $tombol !!}
          </div>
        </div>
      </div>
    </div>
  </div>