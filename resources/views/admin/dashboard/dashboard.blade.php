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
      <div class="col-xl-8">
        <div class="card">
          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col">
                <h3 class="mb-0">Demografi Jemaat</h3>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush table-hover" id="">
              <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Kategori Usia</th>
                        @foreach ($tahun as $thn)
                            <th class="text-center">Data<br>{{ $thn }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php $no=1; @endphp
                    @foreach ($data as $kategori => $tahunData)
                        <tr>
                            <td class="">{{ $no }}</td>
                            <td class="">{{ $kategori }}</td>
                            @foreach ($tahun as $thn)
                                <td class="text-center">{{ $tahunData["Data $thn"] ?? 0 }}</td>
                            @endforeach
                        </tr>
                        @php $no++; @endphp
                    @endforeach
                    <tr class="fw-bold table-secondary thead-light">
                      <th colspan="2" class="text-center">TOTAL</th>
                      @foreach ($tahun as $thn)
                          <th class="text-center">{{ $totalPerTahun[$thn] ?? 0 }}</th>
                      @endforeach
                  </tr>
                </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="card">
          <div class="card-header bg-transparent">
            <div class="row align-items-center">
              <div class="col">
                <h6 class="text-uppercase text-muted ls-1 mb-1">Data Jemaat</h6>
                <h5 class="h3 mb-0">Statistik Jemaat</h5>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="chart">
              <div id="chartContainer">
                <canvas id="grafik"></canvas>
              </div>
              <script>
                var ctx = document.getElementById('grafik').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Aktif', 'Pasif', 'KK Aktif','Atestasi Keluar'],
                        datasets: [{
                            label: 'Jumlah Jemaat',
                            data: [{{ $Jaktif }}, {{ $Jpasif }}, {{ $Jkk }}, {{$Jatestasi}}],
                            backgroundColor: ['#36A2EB', '#FFCE56', '#0a9905', '#e71313'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom', 
                                labels: {
                                    font: {
                                        size: 10
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
