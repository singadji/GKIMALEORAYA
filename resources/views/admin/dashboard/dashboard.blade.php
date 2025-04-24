@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@php
    $btn = '';
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
<style>
        #chartContainer {
            height: 100%; /* Tinggi lebih kecil */
            margin: auto; /* Tengah */
        }
        .dt-buttons .btn {
    margin-left: 0.5rem;
}
    </style>
{{-- Pass the $btn variable to the topnav --}}
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
            <li> &nbsp; - {!! $error !!}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
@endsection

<div class="main-content" id="panel">

<!-- Header -->
  <div class="header bg-primary pb-6">
    <div class="container-fluid">
      <div class="header-body">
        <!-- Card stats -->
        <div class="row">
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <a href="{{ route('admin.detail', 'atestasi') }}">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Jemaat Atestasi Keluar</h5>
                  <span class="h1 font-weight-bold mb-0">{{ $Jatestasi }}</span> Jemaat
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                  <i class="fa fa-solid fa-share"></i>
                  </div>
                </div>
              </div>
            </div>
            <a/>
          </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <a href="{{ route('admin.detail', 'aktif') }}">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Jemaat Aktif</h5>
                  <span class="h1 font-weight-bold mb-0">{{ $Jaktif }}</span> Jemaat
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                  <i class="fa fa-solid fa-users"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <a href="{{ route('administrasi.anggota-baptisan') }}">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Anggota Baptisan</h5>
                  <span class="h1 font-weight-bold mb-0">{{ $baptisan }}</span> Jemaat
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                  <i class="fa fa-solid fa-user"></i>
                  </div>
                </div>
              </div>
            </div>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <a href="{{ route('admin.detail', 'kepala-keluarga') }}">
              <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Kepala Keluarga</h5>
                  <span class="h1 font-weight-bold mb-0">{{ $Jkk }}</span> Kepala Keluarga
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                  <i class="fa fa-solid fa-box-open"></i>
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
  </div>
  <!-- Page content -->
  @if(isset($item))
  @include('admin.dashboard.aksi')
  @else
  <div class="container-fluid mt--6">
    <div class="row">
    @include('admin.dashboard.usia')
    @include('admin.dashboard.umurG')
    @include('admin.dashboard.laporan')

    </div>
    @endif
    <footer class="footer pt-0">
    @include('layouts.footers.auth.footer')
    </footer>
  </div>
  </div>
  
@endsection
