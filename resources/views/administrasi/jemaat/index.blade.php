@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@php
    $btn = '<a href="#" class="btn btn-warning bg-gradient-warning btn-sm mt-3 ms-auto dropdown" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Upload Excel</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                    <a class="dropdown-item" href="'. route('download.template.excel.import', ['filename' => 'Template_Data_Jemaat.xlsx']) .'">Download Template</a>
                    <form action="'.route('administrasi.data-jemaat.import').'" method="POST" enctype="multipart/form-data" id="formImport">
                        '. csrf_field() .'
                        <input type="file" name="file" id="file" class="form-control" style="display: none;" accept=".xlsx,.xls" required>
                        <a href="#" class="dropdown-item" id="importLink">Upload</a>
                    </form>
                </div>
                <a href="' . route('administrasi.data-jemaat.create') . '" class="btn btn-info bg-gradient-info btn-sm mt-3 ms-auto">Jemaat Baru</a>';
    $page = 'Administrasi';
    $judul = 'Data Jemaat';
    $subjudul = 'Administrasi Jemaat';
    $tombol = $btn;
@endphp

@include('layouts.navbars.auth.topnav')

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

@php
    $totalJemaat = $jemaatList->count();
    $totalAktif = $jemaatList->where('status_aktif', 'Aktif')->count();
    $totalMeninggal = $jemaatList->where('status_aktif', 'Meninggal Dunia')->count();
    $totalAtestasi = $jemaatList->where('status_aktif', 'Atestasi Keluar')->count();
    $totalPasif = $jemaatList->where('status_aktif', 'Pasif')->count();
    $totalBukanAnggota = $jemaatList->where('status_aktif', 'Bukan Anggota')->count();
    $totalTidakAktif = $totalPasif + $totalBukanAnggota;
    $totalLaki = $jemaatList->where('gender', 'L')->count();
    $totalPerempuan = $jemaatList->where('gender', 'P')->count();
    $totalKK = $jemaatList->where('is_kk', true)->count();
@endphp

<div class="container-fluid mt--6">

    {{-- Header Card --}}
    <div class="card mb-4" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); border-radius: 12px;">
        <div class="card-body py-4 px-5">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="text-white mb-1" style="font-weight: 700; letter-spacing: 0.5px;">
                        <i class="fas fa-users me-2"></i>Administrasi Data Jemaat
                    </h3>
                    <p class="text-white-50 mb-0" style="font-size: 0.9rem;">
                        Kelola data jemaat, kepala keluarga, dan wilayah pelayanan
                    </p>
                </div>
                <div class="col-auto text-end">
                    <span class="badge" style="background: rgba(255,255,255,0.15); font-size: 0.85rem; padding: 8px 16px; border-radius: 20px;">
                        <i class="fas fa-calendar-alt me-1"></i> {{ now()->translatedFormat('d F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-xl-0">
            <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #0d6efd;">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(13,110,253,0.1); border-radius: 12px;">
                        <i class="fas fa-users text-primary" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Total Jemaat</h6>
                        <h3 class="mb-0" style="font-weight: 700; color: #0d6efd;">{{ $totalJemaat }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-xl-0">
            <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #198754;">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(25,135,84,0.1); border-radius: 12px;">
                        <i class="fas fa-user-check text-success" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Aktif</h6>
                        <h3 class="mb-0" style="font-weight: 700; color: #198754;">{{ $totalAktif }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-xl-0">
            <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #dc3545;">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(220,53,69,0.1); border-radius: 12px;">
                        <i class="fas fa-cross text-danger" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Meninggal</h6>
                        <h3 class="mb-0" style="font-weight: 700; color: #dc3545;">{{ $totalMeninggal }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #fd7e14;">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(253,126,20,0.1); border-radius: 12px;">
                        <i class="fas fa-sign-out-alt text-warning" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Atestasi</h6>
                        <h3 class="mb-0" style="font-weight: 700; color: #fd7e14;">{{ $totalAtestasi }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Additional Stats Row --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-xl-0">
            <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #6c757d;">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(108,117,125,0.1); border-radius: 12px;">
                        <i class="fas fa-user-times text-secondary" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Tidak Aktif</h6>
                        <h3 class="mb-0" style="font-weight: 700; color: #6c757d;">{{ $totalTidakAktif }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-xl-0">
            <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #fd7e14;">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(253,126,20,0.1); border-radius: 12px;">
                        <i class="fas fa-user-clock text-warning" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Pasif</h6>
                        <h3 class="mb-0" style="font-weight: 700; color: #fd7e14;">{{ $totalPasif }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-xl-0">
            <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #6f42c1;">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(111,66,193,0.1); border-radius: 12px;">
                        <i class="fas fa-user-slash text-purple" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Bukan Anggota</h6>
                        <h3 class="mb-0" style="font-weight: 700; color: #6f42c1;">{{ $totalBukanAnggota }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #20c997;">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(32,201,151,0.1); border-radius: 12px;">
                        <i class="fas fa-users text-teal" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Kepala Keluarga</h6>
                        <h3 class="mb-0" style="font-weight: 700; color: #20c997;">{{ $totalKK }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body py-2 px-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
            <ul class="nav nav-tabs nav-fill border-0" role="tablist" style="background: transparent;">
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $statusFilter == 'semua' ? 'active' : '' }}" href="{{ url('administrasi/data-jemaat') }}" style="border-radius: 8px; margin: 0 2px; font-weight: 500;">
                        <i class="fas fa-list me-1"></i> Semua
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $statusFilter == 'Aktif' ? 'active' : '' }}" href="{{ url('administrasi/data-jemaat?status=Aktif') }}" style="border-radius: 8px; margin: 0 2px; font-weight: 500;">
                        <i class="fas fa-user-check me-1 text-success"></i> Aktif
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $statusFilter == 'Tidak Aktif' ? 'active' : '' }}" href="{{ url('administrasi/data-jemaat?status=Tidak%20Aktif') }}" style="border-radius: 8px; margin: 0 2px; font-weight: 500;">
                        <i class="fas fa-user-times me-1 text-secondary"></i> Tidak Aktif
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $statusFilter == 'Pasif' ? 'active' : '' }}" href="{{ url('administrasi/data-jemaat?status=Pasif') }}" style="border-radius: 8px; margin: 0 2px; font-weight: 500;">
                        <i class="fas fa-user-clock me-1 text-warning"></i> Pasif
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $statusFilter == 'Bukan Anggota' ? 'active' : '' }}" href="{{ url('administrasi/data-jemaat?status=Bukan%20Anggota') }}" style="border-radius: 8px; margin: 0 2px; font-weight: 500;">
                        <i class="fas fa-user-slash me-1 text-purple"></i> Bukan Anggota
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $statusFilter == 'Atestasi Keluar' ? 'active' : '' }}" href="{{ url('administrasi/data-jemaat?status=Atestasi%20Keluar') }}" style="border-radius: 8px; margin: 0 2px; font-weight: 500;">
                        <i class="fas fa-sign-out-alt me-1 text-danger"></i> Atestasi Keluar
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $statusFilter == 'Meninggal Dunia' ? 'active' : '' }}" href="{{ url('administrasi/data-jemaat?status=Meninggal%20Dunia') }}" style="border-radius: 8px; margin: 0 2px; font-weight: 500;">
                        <i class="fas fa-cross me-1 text-dark"></i> Meninggal
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="card mb-10 border-0 shadow-sm">
        <div class="card-header border-bottom-0 pb-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
            <div class="d-flex align-items-center justify-content-between py-2">
                <h6 class="mb-0 text-dark">
                    <i class="fas fa-table me-2 text-primary"></i>Daftar Jemaat
                </h6>
                <span class="badge badge-primary px-3 py-2">
                    Total: {{ number_format($totalJemaat) }} jemaat (KK: {{ $totalKK }}, L: {{ $totalLaki }}, P: {{ $totalPerempuan }})
                </span>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="">
                <div id="alert">
                    @include('includes.alert')
                </div>
            </div>
            <div class="table-responsive p-4" style="overflow-x:auto; overflow-y:auto;">
                <table class="display table align-items-center mb-2 table-hover data-table" id="dataTable" style="width: 100%; table-layout: fixed;">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th style="width: 80px;">N I A</th>
                            <th style="width: 120px;">Nama Jemaat</th>
                            <th class="text-center" style="width: 50px;">L/P</th>
                            <th style="width: 320px;">Alamat</th>
                            <th class="text-center" style="width: 50px;">Wil.</th>
                            <th class="text-center" style="width: 120px;">No. Telepon/HP</th>
                            <th class="text-center" style="width: 100px;">Status</th>
                            <th class="text-center" style="width: 80px;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jemaatList as $item)
                            @include('components.jemaat-table-row-enhanced', ['item' => $item, 'loop' => $loop])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>

@endsection

@push('scripts')
<style>
    .badge-outline-primary {
        border: 1.5px solid #5e72e4;
        color: #5e72e4;
        background: rgba(94,114,228,0.08);
        font-size: 0.75rem;
    }
    .badge-pill {
        border-radius: 20px;
    }
    .badge-success {
        background-color: #198754 !important;
    }
    .badge-danger {
        background-color: #dc3545 !important;
    }
    .badge-warning {
        background-color: #fd7e14 !important;
        color: #212529 !important;
    }
    .badge-info {
        background-color: #0dcaf0 !important;
        color: #212529 !important;
    }
</style>
<script>
    document.getElementById('importLink').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('file').click();
    });

    document.getElementById('file').addEventListener('change', function () {
        if (this.files.length > 0) {
            document.getElementById('formImport').submit();
        }
    });
</script>
@endpush