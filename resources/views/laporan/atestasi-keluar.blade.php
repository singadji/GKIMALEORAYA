@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav')
@php
    use Carbon\Carbon;
    $total = count($data);
    $laki = $data->where('gender', 'L')->count();
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

        {{-- Header Card --}}
        <div class="card mb-4" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); border-radius: 12px;">
            <div class="card-body py-4 px-5">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="text-white mb-1" style="font-weight: 700; letter-spacing: 0.5px;">
                            <i class="fas fa-sign-out-alt me-2"></i>{!! $Hjudul !!}
                        </h3>
                        <p class="text-white-50 mb-0" style="font-size: 0.9rem;">
                            Data jemaat yang telah melakukan atestasi keluar dari GKImaleoraya
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

        {{-- Filter Form (di bawah header) --}}
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body py-3 px-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                <form method="GET" action="{{ url('laporan/atestasi-keluar') }}" id="filterForm">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.8rem;">
                                <i class="fas fa-calendar-alt me-1 text-primary"></i> Tanggal Awal
                            </label>
                            <input type="date" name="tanggal_awal" class="form-control form-control-sm"
                                   value="{{ $tanggalAwal ?? '' }}"
                                   style="border-radius: 0.5rem;" onchange="this.form.submit()">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.8rem;">
                                <i class="fas fa-calendar-alt me-1 text-danger"></i> Tanggal Akhir
                            </label>
                            <input type="date" name="tanggal_akhir" class="form-control form-control-sm"
                                   value="{{ $tanggalAkhir ?? '' }}"
                                   style="border-radius: 0.5rem;" onchange="this.form.submit()">
                        </div>
                        @if(!empty($tanggalAwal))
                            <div class="col-md-4">
                                <a href="{{ url('laporan/atestasi-keluar') }}" class="btn btn-outline-secondary btn-sm w-100" style="border-radius: 0.5rem; height: 2.25rem;">
                                    <i class="fas fa-times me-1"></i> Reset Filter
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if(!empty($tanggalAwal))
            <div class="d-flex align-items-center mb-3 p-3" style="border-left: 4px solid #0d47a1; background-color: #d6eaf8; border-radius: 8px;">
                <i class="fas fa-filter me-3" style="color:#0d47a1; font-size:1.2rem;"></i>
                <div style="color:#1a1a1a; font-size:0.85rem; line-height:1.6;">
                    <strong style="color:#0d47a1;">Filter aktif:</strong>
                    Menampilkan atestasi keluar tanggal
                    <span class="badge" style="background-color:#0d47a1; color:#fff; font-size:0.8rem;">{{ \Carbon\Carbon::parse($tanggalAwal)->translatedFormat('d F Y') }}</span>
                    s/d
                    <span class="badge" style="background-color:#0d47a1; color:#fff; font-size:0.8rem;">{{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}</span>
                    —
                    <strong>{{ number_format($total) }}</strong> data ditemukan.
                </div>
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-xl-0">
                <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #0d6efd;">
                    <div class="card-body d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(13,110,253,0.1); border-radius: 12px;">
                            <i class="fas fa-users text-primary" style="font-size: 1.3rem;"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Total Atestasi Keluar</h6>
                            <h3 class="mb-0" style="font-weight: 700; color: #0d6efd;">{{ $total }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-xl-0">
                <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #198754;">
                    <div class="card-body d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(25,135,84,0.1); border-radius: 12px;">
                            <i class="fas fa-mars text-success" style="font-size: 1.3rem;"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Laki-Laki</h6>
                            <h3 class="mb-0" style="font-weight: 700; color: #198754;">{{ $laki }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #e83e8c;">
                    <div class="card-body d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(232,62,140,0.1); border-radius: 12px;">
                            <i class="fas fa-venus" style="font-size: 1.3rem; color: #e83e8c;"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Perempuan</h6>
                            <h3 class="mb-0" style="font-weight: 700; color: #e83e8c;">{{ $perempuan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="card mb-10 border-0 shadow-sm">
            <div class="card-header border-bottom-0 pb-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                <div class="d-flex align-items-center justify-content-between py-2">
                    <h6 class="mb-0 text-dark">
                        <i class="fas fa-table me-2 text-primary"></i>Daftar Atestasi Keluar
                    </h6>
                    <span class="badge badge-primary px-3 py-2">
                        Total: {{ number_format($total) }} records
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
                    <table class="display table align-items-center mb-2 table-hover data-table" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>N I A</th>
                                <th>Nama Jemaat</th>
                                <th class="text-center">L/P</th>
                                <th class="text-center">Wil.</th>
                                <th>Alamat</th>
                                <th class="text-center">No. Telepon/HP</th>
                                <th class="text-center">Tanggal<br>Atestasi Keluar</th>
                                <th>Gereja Tujuan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @forelse($data as $item)
                                <tr onclick="window.location='{{ route('administrasi.data-jemaat.show', $item->id_jemaat) }}';" style="cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#f0f4ff'" onmouseout="this.style.background='transparent'">
                                    <td class="text-center text-muted">{{ $no }}</td>
                                    <td>
                                        <span class="font-weight-bold text-dark">{{ $item->nia }}</span>
                                    </td>
                                    <td>
                                        <span class="font-weight-500">{{ $item->nama_jemaat }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($item->gender == 'L')
                                            <span class="badge badge-info" style="font-size: 0.75rem;">
                                                <i class="fas fa-mars me-1"></i>L
                                            </span>
                                        @elseif($item->gender == 'P')
                                            <span class="badge badge-danger" style="font-size: 0.75rem;">
                                                <i class="fas fa-venus me-1"></i>P
                                            </span>
                                        @else
                                            <span class="badge badge-secondary" style="font-size: 0.75rem;">{{ $item->gender }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-outline-primary px-2 py-1" style="border: 1.5px solid #5e72e4; color: #5e72e4; background: rgba(94,114,228,0.08); font-size: 0.75rem;">
                                            {{ $item->hubunganKeluarga?->kkJemaat?->id_group_wilayah ?? '-' }}
                                        </span>
                                    </td>
                                    <td style="max-width: 250px; white-space: normal; word-wrap: break-word;">
                                        <span class="text-muted">{{ $item->alamat ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-muted">{{ $item->telepon ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="font-weight-500">
                                            {{ $item->tanggal ? Carbon::parse($item->tanggal)->translatedFormat('d F Y') : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $item->gereja ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $item->keterangan }}</span>
                                    </td>
                                </tr>
                                @php $no++; @endphp
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div>
                                            <i class="fas fa-inbox" style="font-size: 2.5rem; color: #c4c9d4;"></i>
                                            <p class="mt-3 mb-0" style="color: #8898aa; font-weight: 500;">Tidak ada data atestasi keluar</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection