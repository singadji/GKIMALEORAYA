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
            <a href="{{ route('admin.detail', 'atestasi') }}">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Jemaat Atestasi</h5>
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
        
        <div class="col-xl-4 col-md-6">
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
        <div class="col-xl-4 col-md-6">
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
          @if(isset($item))
          <div class="table-responsive p-4" style="overflow-x:auto; overflow-y:auto;"  id="DW">
            {!! $Hjudul !!}
                    <table data-excluded-columns="0" style="line-height: 1.3; width:100%; color:#333333;" class="display table align-items-center mb-2 table-hover data-table nowrap" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase font-weight-bolder" width="10">#</th>
                                <th class="text-uppercase font-weight-bolder" width="30px">N I A</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Nama Jemaat</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Alamat Domisili</th>
                                <th class="text-uppercase font-weight-bolder ps-2">No. Telepon/HP</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Status Keanggotaan</th>
                                <!-- <th class=""></th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($item as $item)
                                @php
                                    $isKK = $item->kkJemaat ? true : false;
                                @endphp
                                <tr onclick="window.location='{{ route('administrasi.data-jemaat.show', $item->id_jemaat) }}';" style="cursor: pointer;">
                                    <td class="align-middle">{!! $no !!}</td>
                                    <td class="text-center font-weight-bold" width="30px" style="word-wrap: break-word; white-space: normal !important;">
                                        {!!  $item->nia !!}
                                    </td>
                                    <td class="align-left">
                                        {!!  $item->nama_jemaat !!}
                                        @if($item->status_aktif == "Meninggal Dunia")
                                            <sup><i class="fa fa-solid fa-cross" style="color:purple;"></i></sup>
                                        @endif
                                        @if($item->status_aktif == "Atestasi")
                                            <sup><i class="fa fa-solid fa-share" style="color:red"></i></sup>
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        @if($isKK)
                                            {{ $item->kkJemaat->alamat }} <!-- Alamat dari KK Jemaat -->
                                        @elseif ($item->hubunganKeluarga && $item->hubunganKeluarga->kkJemaat)
                                            {{ $item->hubunganKeluarga->kkJemaat->alamat }} <!-- Alamat dari Hubungan Keluarga -->
                                        @else
                                            Tidak Diketahui
                                        @endif
                                        </td>
                                    <td class="text-center">
                                        {!!  $item->telepon !!}
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $badgeClass = $item->status_aktif == 'Aktif' ? 'bg-gradient-success' :
                                                        ($item->status_aktif == 'Meninggal Dunia' ? 'bg-gradient-purple' : 'bg-gradient-danger');
                                        @endphp
                                        <span class="badge {{ $badgeClass }} text-white">{!! $item->status_aktif !!} - {!! $item->keterangan !!}</span>
                                    </td>
                                    
                                </tr>
                                @php $no++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
          @else
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
                            data: [{{ $Jaktif }}, {{ $Jatestasi }}, {{ $Jkk }}],
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
            @endif
        </div>
      </div>
    </div>
  </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection
