@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav')
@php
    use Carbon\Carbon;
    $total     = $data->count();
    $laki      = $data->where('gender', 'L')->count();
    $perempuan = $data->where('gender', 'P')->count();
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

        {{-- Styled Header --}}
        <div class="card mb-4 border-0 shadow-sm"
             style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
            <div class="card-body py-4 px-5">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div>
                        <h1 class="text-white mb-1" style="font-size: 1.6rem; font-weight: 700;">
                            <i class="fas fa-birthday-cake mr-2"></i>{!! $Hjudul !!}
                        </h1>
                        <p class="text-white-50 mb-0" style="font-size: 0.85rem;">
                            Daftar jemaat berdasarkan tanggal lahir
                        </p>
                    </div>
                    <div class="mt-2 mt-md-0">
                        <span class="badge badge-pill badge-light px-3 py-2" style="font-size: 0.85rem;">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            {{ now()->translatedFormat('d F Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-xl-0 mb-3">
                <div class="card card-stats shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-lg icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-sm mb-0 text-uppercase text-muted">Total Jemaat</p>
                                <h5 class="font-weight-bold mb-0">{{ number_format($total) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-xl-0 mb-3">
                <div class="card card-stats shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-lg icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="fas fa-mars"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-sm mb-0 text-uppercase text-muted">Laki-Laki</p>
                                <h5 class="font-weight-bold mb-0">{{ number_format($laki) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card card-stats shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-lg icon-shape bg-gradient-danger text-white rounded-circle shadow">
                                <i class="fas fa-venus"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-sm mb-0 text-uppercase text-muted">Perempuan</p>
                                <h5 class="font-weight-bold mb-0">{{ number_format($perempuan) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Form (auto-submit) --}}
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body py-3 px-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                <form method="GET" action="{{ route('laporan.jemaat-tanggal-lahir') }}" id="filterForm">
                    <div class="row align-items-end">
                        <div class="col-md-2">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.8rem;">
                                <i class="fas fa-calendar-alt me-1 text-primary"></i> Bulan Awal
                            </label>
                            <select name="bulan_awal" class="form-control form-control-sm" style="border-radius: 0.5rem;" onchange="this.form.submit()">
                                @for($i=1; $i<=12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan_awal') == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.8rem;">
                                <i class="fas fa-calendar-day me-1 text-primary"></i> Tanggal Awal
                            </label>
                            <select name="hari_awal" class="form-control form-control-sm" style="border-radius: 0.5rem;" onchange="this.form.submit()">
                                @for($i=1; $i<=31; $i++)
                                    <option value="{{ $i }}" {{ request('hari_awal') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.8rem;">
                                <i class="fas fa-calendar-alt me-1 text-danger"></i> Bulan Akhir
                            </label>
                            <select name="bulan_akhir" class="form-control form-control-sm" style="border-radius: 0.5rem;" onchange="this.form.submit()">
                                @for($i=1; $i<=12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan_akhir') == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.8rem;">
                                <i class="fas fa-calendar-day me-1 text-danger"></i> Tanggal Akhir
                            </label>
                            <select name="hari_akhir" class="form-control form-control-sm" style="border-radius: 0.5rem;" onchange="this.form.submit()">
                                @for($i=1; $i<=31; $i++)
                                    <option value="{{ $i }}" {{ request('hari_akhir') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        @if(request()->has('bulan_awal'))
                            <div class="col-md-2">
                                <a href="{{ route('laporan.jemaat-tanggal-lahir') }}" class="btn btn-outline-secondary btn-sm w-100" style="border-radius: 0.5rem; height: 2.25rem;">
                                    <i class="fas fa-times me-1"></i> Reset Filter
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if(request()->has('bulan_awal'))
            <div class="d-flex align-items-center mb-3 p-3" style="border-left: 4px solid #0d47a1; background-color: #d6eaf8; border-radius: 8px;">
                <i class="fas fa-filter me-3" style="color:#0d47a1; font-size:1.2rem;"></i>
                <div style="color:#1a1a1a; font-size:0.85rem; line-height:1.6;">
                    <strong style="color:#0d47a1;">Filter aktif:</strong>
                    Menampilkan jemaat yang lahir tanggal
                    <span class="badge" style="background-color:#0d47a1; color:#fff; font-size:0.8rem;">{{ \Carbon\Carbon::create()->month((int) $bulanAwal)->translatedFormat('F') }} {{ $hariAwal }}</span>
                    s/d
                    <span class="badge" style="background-color:#0d47a1; color:#fff; font-size:0.8rem;">{{ \Carbon\Carbon::create()->month((int) $bulanAkhir)->translatedFormat('F') }} {{ $hariAkhir }}</span>
                    —
                    <strong>{{ number_format($total) }}</strong> jemaat ditemukan.
                </div>
            </div>
        @endif

        {{-- Data Table --}}
        <div class="card mb-10 border-0 shadow-sm">
            <div class="card-header border-bottom-0 pb-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                <div class="d-flex align-items-center justify-content-between py-2">
                    <h6 class="mb-0 text-dark">
                        <i class="fas fa-list mr-1 text-primary"></i> Daftar Jemaat Tanggal Lahir
                    </h6>
                    <span class="badge badge-primary px-3 py-2">
                        Total: {{ number_format($total) }} records
                    </span>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="display table align-items-center mb-2 table-hover data-table" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>NIA</th>
                                <th>Nama Jemaat</th>
                                <th class="text-center">Gender</th>
                                <th>Wilayah</th>
                                <th>Alamat</th>
                                <th>No. Telepon</th>
                                <th>Tanggal Lahir</th>
                                <th>Tgl Terdaftar</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                                <tr
                                    @if(!empty($item->id_jemaat))
                                        onclick="window.open(
                                            '{{ route('administrasi.data-jemaat.show', ['data_jemaat' => $item->id_jemaat]) }}',
                                            '_blank'
                                        )"
                                        style="cursor:pointer;"
                                    @endif
                                >
                                    <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="font-weight-bold text-dark">{{ $item->nia }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm rounded-circle bg-gradient-secondary text-white d-flex align-items-center justify-content-center me-2"
                                                 style="width: 32px; height: 32px; font-size: 0.75rem;">
                                                {{ strtoupper(substr($item->nama_jemaat ?? 'X', 0, 1)) }}
                                            </div>
                                            <span class="font-weight-600">{{ $item->nama_jemaat }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($item->gender === 'L')
                                            <span class="badge badge-info" style="font-size: 0.75rem;">
                                                <i class="fas fa-mars mr-1"></i>Laki-Laki
                                            </span>
                                        @elseif($item->gender === 'P')
                                            <span class="badge badge-danger" style="font-size: 0.75rem;">
                                                <i class="fas fa-venus mr-1"></i>Perempuan
                                            </span>
                                        @else
                                            <span class="badge badge-secondary" style="font-size: 0.75rem;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->id_group_wilayah)
                                            <span class="badge badge-outline-primary px-2 py-1"
                                                  style="border: 1.5px solid #5e72e4; color: #5e72e4; background: rgba(94,114,228,0.08); font-size: 0.75rem;">
                                                Wilayah {{ $item->id_group_wilayah }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-left" style="max-width: 400px; white-space: normal; word-wrap: break-word;">
                                        {{ $item->alamat ?? '-' }}
                                    </td>
                                    <td>
                                        @if($item->telepon)
                                            <a href="tel:{{ $item->telepon }}" class="text-decoration-none text-dark">
                                                <i class="fas fa-phone-alt text-success mr-1" style="font-size: 0.7rem;"></i>{{ $item->telepon }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->tanggal_lahir)
                                            <span class="text-nowrap">
                                                <i class="fas fa-birthday-cake text-warning mr-1" style="font-size: 0.7rem;"></i>
                                                {{ Carbon::parse($item->tanggal_lahir)->translatedFormat('d F Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->tanggal_terdaftar)
                                            <span class="text-nowrap">
                                                <i class="fas fa-calendar-day text-primary mr-1" style="font-size: 0.7rem;"></i>
                                                {{ Carbon::parse($item->tanggal_terdaftar)->translatedFormat('d F Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->keterangan)
                                            <span class="text-dark" style="font-size: 0.85rem;">{{ $item->keterangan }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                            <h6 class="text-muted mb-1">Tidak ada data ditemukan</h6>
                                            <p class="text-muted mb-0" style="font-size: 0.8rem;">
                                                Belum ada data jemaat tanggal lahir yang tersedia.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Total Records Counter --}}
                @if($total > 0)
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                        <span class="text-muted" style="font-size: 0.85rem;">
                            Menampilkan {{ number_format($total) }} dari {{ number_format($total) }} data
                        </span>
                        <span class="badge badge-success px-3 py-2">
                            <i class="fas fa-check-circle mr-1"></i>
                            {{ number_format($total) }} records
                        </span>
                    </div>
                @endif
            </div>
        </div>

    @include('layouts.footers.auth.footer')
</div>

@endsection
