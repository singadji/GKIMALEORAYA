@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@php
    $btn = '';
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    #chartContainer {
        height: 100%;
        margin: auto;
    }
    .dt-buttons .btn {
        margin-left: 0.5rem;
    }
    .welcome-banner {
        background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%);
        border-radius: 16px;
        padding: 24px 30px;
        color: #fff;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .welcome-banner h4 {
        font-weight: 700;
        margin-bottom: 4px;
    }
    .welcome-banner p {
        opacity: 0.85;
        font-size: 0.9rem;
        margin: 0;
    }
    .stat-card {
        border: none;
        border-radius: 14px;
        transition: transform 0.2s, box-shadow 0.2s;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    }
    .stat-card .card-body {
        padding: 20px;
    }
    .stat-card .card-title {
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .stat-card .h1 {
        font-size: 1.8rem;
        line-height: 1;
    }
    .stat-card .unit {
        font-size: 0.8rem;
        color: #888;
        margin-left: 4px;
    }
    .stat-card a {
        text-decoration: none;
        color: inherit;
    }
    .icon-stat {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
</style>

@include('layouts.navbars.auth.topnav', [
        $btn    = '',
        $page   = 'Dashboard',
        $judul  = 'Administrasi Gereja Kristen Indonesia Jemaat Maleo Raya',
        $subjudul = '',
        $tombol = $btn,
])

@section('alert-error')
@if (Session::has('errors'))
<div class="col-md-12">
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">×</span></button>
        <strong>Oops, terjadi kesalahan. </strong>
        <ul style="font-size:12px;margin-top:5px;">
            @foreach ($errors->all() as $error)
            <li> &nbsp; - {{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
@endsection

<div class="main-content" id="panel">

  <div class="header bg-primary pb-6">
    <div class="container-fluid">
      <div class="header-body">
        <div class="welcome-banner">
          <h4>Selamat Datang, {{ Auth::user()->name }}!</h4>
          <p>Kelola data jemaat GKI Maleo Raya dari panel admin ini.</p>
        </div>

        <div class="row">
          <div class="col-xl-3 col-md-6 mb-xl-0">
            <a href="{{ route('admin.detail', 'atestasi') }}">
              <div class="card card-stats stat-card">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-1">Atestasi Keluar</h5>
                      <span class="h2 font-weight-bold mb-0 text-danger">{{ $jJ['atestasi_keluar'] }}</span>
                      <span class="unit">Jemaat</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon-stat bg-gradient-red text-white rounded-circle shadow">
                        <i class="fas fa-share"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xl-3 col-md-6 mb-xl-0">
            <a href="{{ route('admin.detail', 'aktif') }}">
              <div class="card card-stats stat-card">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-1">Jemaat Aktif</h5>
                      <span class="h2 font-weight-bold mb-0 text-success">{{ $jJ['total_jemaat'] }}</span>
                      <span class="unit">Jemaat</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon-stat bg-gradient-success text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xl-3 col-md-6 mb-xl-0">
            <a href="{{ route('administrasi.anggota-baptisan') }}">
              <div class="card card-stats stat-card">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-1">Calon Sidi</h5>
                      <span class="h2 font-weight-bold mb-0 text-warning">{{ $jJ['baptisan'] }}</span>
                      <span class="unit">Jemaat</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon-stat bg-gradient-warning text-white rounded-circle shadow">
                        <i class="fas fa-user"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xl-3 col-md-6">
            <a href="{{ route('admin.detail', 'kepala-keluarga') }}">
              <div class="card card-stats stat-card">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-1">Kepala Keluarga</h5>
                      <span class="h2 font-weight-bold mb-0 text-info">{{ $jJ['jemaat_kk'] }}</span>
                      <span class="unit">KK</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon-stat bg-gradient-info text-white rounded-circle shadow">
                        <i class="fas fa-home"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Page content -->
  @if(isset($item))
    @if($detail === 'kepala-keluarga')
        @include('admin.dashboard.kepala-keluarga')
    @else
      @include('admin.dashboard.aksi')
    @endif
  @else
  <div class="container-fluid mt--6">
    <div class="row">
        @include('admin.dashboard.usia')
        @include('admin.dashboard.umurG')
        @include('admin.dashboard.laporan')
    </div>
  </div>
@endif
    @include('layouts.footers.auth.footer')
</div>
</div>

@endsection
