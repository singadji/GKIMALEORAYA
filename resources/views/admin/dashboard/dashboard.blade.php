@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@php
    $btn = '';
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
<style>
        #chartContainer {
            width: 300px; /* Lebar lebih kecil */
            height: 300px; /* Tinggi lebih kecil */
            margin: auto; /* Tengah */
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
          
      <!-- Card stats -->
      @if(\Auth::user()->role == 'Administrator')
        
      <div class="row">
        <div class="col-xl-4 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Jemaat Atestasi</h5>
                  <span class="h1 font-weight-bold mb-0">{{ $atestasi }}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                  <i class="fa fa-solid fa-share"></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                <span class="text-nowrap"></span>
              </p>
            </div>
          </div>
        </div>
        
        <div class="col-xl-4 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Jemaat Aktif</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $aktif }}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                  <i class="fa fa-solid fa-users"></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                <span class="text-nowrap"></span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Kepala Keluarga</h5>
                  <span class="h2 font-weight-bold mb-0">{{ $kk }}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                  <i class="fa fa-solid fa-box-open"></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                <span class="text-nowrap"></span>
              </p>
            </div>
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body">
        <div id="chartContainer">
        <canvas id="chartPie"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('chartPie').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie', // Bisa diubah ke 'bar' atau 'doughnut'
            data: {
                labels: ['Aktif', 'Atestasi', 'KK Aktif'],
                datasets: [{
                    label: 'Jumlah Jemaat',
                    data: [{{ $aktif }}, {{ $atestasi }}, {{ $kk }}],
                    backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Supaya bisa diatur ukuran
                plugins: {
                    legend: {
                        position: 'bottom', // Supaya legend tidak memakan banyak tempat
                        labels: {
                            font: {
                                size: 10 // Ukuran teks lebih kecil
                            }
                        }
                    }
                }
            }
        });
    </script>
        </div>
      </div>
    </div>
  </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection
