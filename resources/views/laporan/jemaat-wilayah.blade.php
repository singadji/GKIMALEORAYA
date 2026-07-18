@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav')
@php
    use Carbon\Carbon;
@endphp
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

    <div class="container-fluid mt--6">

        {{-- 🔖 Header --}}
        <div class="card mb-4 border-0 shadow-sm" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
            <div class="card-body py-4 px-5">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="text-white mb-1" style="font-weight: 700; font-size: 1.6rem;">
                            <i class="fas fa-map-marker-alt me-2"></i>{!! $Hjudul !!}
                        </h1>
                        <p class="text-white-50 mb-0" style="font-size: 0.9rem;">
                            Laporan data jemaat berdasarkan wilayah pelayanan
                        </p>
                    </div>
                    @if($wilayahId && count($data) > 0)
                        <div class="text-end">
                            <span class="badge bg-white text-dark px-3 py-2" style="font-size: 0.85rem; border-radius: 1rem;">
                                <i class="fas fa-database me-1"></i> {{ count($data) }} data ditemukan
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div>
            <div id="alert">
                @include('includes.alert')
            </div>
        </div>

        {{-- 🔽 Dropdown Wilayah --}}
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body py-3 px-4">
                <form method="GET" id="wilayahForm">
                    <div class="row align-items-end">
                        <div class="col-md-5 col-lg-4">
                            <label for="wilayah_id" class="form-label fw-bold text-dark mb-1" style="font-size: 0.85rem;">
                                <i class="fas fa-filter me-1 text-primary"></i> Filter Wilayah
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0" style="border-radius: 0.5rem 0 0 0.5rem;">
                                    <i class="fas fa-map-pin text-muted"></i>
                                </span>
                                <select id="wilayah_id" name="wilayah_id"
                                    class="form-control border-start-0 ps-0"
                                    style="height: 2.75rem; border-radius: 0 0.5rem 0.5rem 0;"
                                    onchange="window.location.href='{{ url('laporan/jemaat-wilayah') }}/' + this.value;">
                                    <option value="">-- Semua Wilayah --</option>
                                    @foreach ($wilayah as $item)
                                        <option value="{{ $item->id_group_wilayah }}"
                                            {{ $wilayahId == $item->id_group_wilayah ? 'selected' : '' }}>
                                            Wilayah {{ $item->id_group_wilayah }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if($wilayahId)
                            <div class="col-md-3 col-lg-2 mt-2 mt-md-0">
                                <a href="{{ url('laporan/jemaat-wilayah') }}"
                                   class="btn btn-outline-secondary btn-sm w-100"
                                   style="border-radius: 0.5rem; height: 2.75rem;">
                                    <i class="fas fa-times me-1"></i> Reset Filter
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if($wilayahId && count($data) > 0)
            {{-- 🔢 Stats Cards --}}
            @php
                $total = count($data);
                $laki = $data->where('gender', 'L')->count();
                $perempuan = $data->where('gender', 'P')->count();
            @endphp

            <div class="row mb-4">
                <div class="col-lg-4 col-md-6 mb-2">
                    <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0d6efd !important;">
                        <div class="card-body d-flex align-items-center py-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                 style="width: 48px; height: 48px; background: rgba(13, 110, 253, 0.1);">
                                <i class="fas fa-users text-primary"></i>
                            </div>
                            <div>
                                <div class="text-muted mb-0" style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                    Total Jemaat
                                </div>
                                <div class="fw-bold text-dark" style="font-size: 1.4rem;">{{ $total }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-2">
                    <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #198754 !important;">
                        <div class="card-body d-flex align-items-center py-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                 style="width: 48px; height: 48px; background: rgba(25, 135, 84, 0.1);">
                                <i class="fas fa-mars text-success"></i>
                            </div>
                            <div>
                                <div class="text-muted mb-0" style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                    Laki-Laki
                                </div>
                                <div class="fw-bold text-dark" style="font-size: 1.4rem;">{{ $laki }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-2">
                    <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #d63384 !important;">
                        <div class="card-body d-flex align-items-center py-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                 style="width: 48px; height: 48px; background: rgba(214, 51, 132, 0.1);">
                                <i class="fas fa-venus text-pink"></i>
                            </div>
                            <div>
                                <div class="text-muted mb-0" style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                    Perempuan
                                </div>
                                <div class="fw-bold text-dark" style="font-size: 1.4rem;">{{ $perempuan }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- 🔽 Tabel Data Jemaat --}}
        @if($wilayahId)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-4" style="overflow-x:auto; overflow-y:auto;">
                    <table data-excluded-columns="0" style="line-height: 1.3; width:100%; color:#333333; display:none;" class="display table align-items-center mb-2 table-hover data-table nowrap" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase font-weight-bolder text-center" width="10">#</th>
                                <th class="text-uppercase font-weight-bolder" width="30px">NIA</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Nama Jemaat</th>
                                <th class="text-uppercase font-weight-bolder ps-2">L/P</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Wilayah</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Tgl Lahir</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Tgl Baptis</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Tgl Sidi</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Status Nikah</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Tgl Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                                <tr onclick="window.location='{{ route('administrasi.data-jemaat.show', $item->id_jemaat) }}';" style="cursor: pointer;">
                                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                    <td class="text-center font-weight-bold" style="word-wrap: break-word; white-space: normal !important;">
                                        {{ $item->nia }}
                                    </td>
                                    <td class="align-left">
                                        <strong>{{ $item->nama_jemaat }}</strong>
                                    </td>
                                    <td class="align-left">
                                        @if($item->gender == 'L')
                                            <span class="badge" style="background-color:#0d6efd; color:#fff;"><i class="fas fa-mars me-1"></i>L</span>
                                        @elseif($item->gender == 'P')
                                            <span class="badge" style="background-color:#d63384; color:#fff;"><i class="fas fa-venus me-1"></i>P</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $item->gender }}</span>
                                        @endif
                                    </td>
                                    <td class="align-left">
                                        <span class="badge bg-info text-white">{{ $item->id_group_wilayah ? 'Wilayah '.$item->id_group_wilayah : '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ ($item->tanggal_baptis && $item->tanggal_baptis != '1900-01-01') ? \Carbon\Carbon::parse($item->tanggal_baptis)->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ ($item->tanggal_sidi && $item->tanggal_sidi != '1900-01-01') ? \Carbon\Carbon::parse($item->tanggal_sidi)->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        @if($item->status_menikah)
                                            <span class="badge" style="background-color:#fd7e14; color:#fff;">{{ $item->status_menikah }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $item->tanggal_terdaftar ? \Carbon\Carbon::parse($item->tanggal_terdaftar)->translatedFormat('d M Y') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <i class="fas fa-inbox fa-2x text-muted mb-2" style="opacity:0.3;"></i><br>
                                        <span class="text-muted">
                                            @if($wilayahId)
                                                Tidak ada data jemaat di wilayah ini.
                                            @else
                                                Silakan pilih wilayah terlebih dahulu.
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Skeleton loader (hanya tampil jika wilayah dipilih) --}}
                    @if($wilayahId)
                    <div id="tableLoader">
                        <table class="table align-items-center mb-2 table-hover" style="width:100%; line-height:1.3;">
                            <thead>
                                <tr>
                                    <th style="background:#f2f2f2;">#</th>
                                    <th style="background:#f2f2f2;">NIA</th>
                                    <th style="background:#f2f2f2;">Nama</th>
                                    <th style="background:#f2f2f2;">L/P</th>
                                    <th style="background:#f2f2f2;">Wilayah</th>
                                    <th style="background:#f2f2f2;">Tgl Lahir</th>
                                    <th style="background:#f2f2f2;">Tgl Baptis</th>
                                    <th style="background:#f2f2f2;">Tgl Sidi</th>
                                    <th style="background:#f2f2f2;">Nikah</th>
                                    <th style="background:#f2f2f2;">Tgl Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 0; $i < 5; $i++)
                                <tr>
                                    <td><div class="skeleton-line" style="width:20px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                    <td><div class="skeleton-line" style="width:60px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                    <td><div class="skeleton-line" style="width:140px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                    <td><div class="skeleton-line" style="width:25px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                    <td><div class="skeleton-line" style="width:60px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                    <td><div class="skeleton-line" style="width:80px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                    <td><div class="skeleton-line" style="width:80px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                    <td><div class="skeleton-line" style="width:80px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                    <td><div class="skeleton-line" style="width:60px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                    <td><div class="skeleton-line" style="width:80px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                        <style>
                            @keyframes shimmer { 0% { background-position: -400px 0; } 100% { background-position: 400px 0; } }
                            .skeleton-line { background: linear-gradient(90deg, #e9ecef 25%, #f8f9fa 50%, #e9ecef 75%); background-size: 800px 100%; animation: shimmer 1.5s infinite; }
                        </style>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center py-5">
                <i class="fas fa-map-marker-alt text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                <h5 class="text-muted mb-2">Pilih Wilayah Pelayanan</h5>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Gunakan dropdown di atas untuk memilih wilayah dan melihat data jemaat.</p>
            </div>
        </div>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var observer = setInterval(function () {
                    if (typeof $.fn.DataTable !== 'undefined' && $.fn.DataTable.isDataTable('#dataTable')) {
                        clearInterval(observer);
                        var loader = document.getElementById('tableLoader');
                        var dt = document.getElementById('dataTable');
                        if (loader) loader.style.display = 'none';
                        if (dt) dt.style.display = '';
                    }
                }, 100);
            });
        </script>

    @include('layouts.footers.auth.footer')
</div>

@endsection
