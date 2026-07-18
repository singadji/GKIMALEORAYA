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

        {{-- Header Card --}}
        <div class="card mb-4" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); border-radius: 12px;">
            <div class="card-body py-4 px-5">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="text-white mb-1" style="font-weight: 700; letter-spacing: 0.5px;">
                            <i class="fas fa-calendar-check me-2"></i>{!! $Hjudul !!}
                        </h3>
                        <p class="text-white-50 mb-0" style="font-size: 0.9rem;">
                            Daftar jemaat berdasarkan periode pendaftaran
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
            <div class="col-xl-4 col-md-6 mb-xl-0">
                <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #0d6efd;">
                    <div class="card-body d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(13,110,253,0.1); border-radius: 12px;">
                            <i class="fas fa-users text-primary" style="font-size: 1.3rem;"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Total Jemaat</h6>
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

        {{-- Filter Form (auto-submit) --}}
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body py-3 px-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                <form method="GET" action="{{ route('laporan.jemaat-tanggal-daftar') }}" id="filterForm">
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
                                <a href="{{ route('laporan.jemaat-tanggal-daftar') }}" class="btn btn-outline-secondary btn-sm w-100" style="border-radius: 0.5rem; height: 2.25rem;">
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
                    Menampilkan jemaat yang terdaftar tanggal
                    <span class="badge" style="background-color:#0d47a1; color:#fff; font-size:0.8rem;">{{ \Carbon\Carbon::parse($tanggalAwal)->translatedFormat('d F Y') }}</span>
                    s/d
                    <span class="badge" style="background-color:#0d47a1; color:#fff; font-size:0.8rem;">{{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}</span>
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
                        <i class="fas fa-list me-2 text-primary"></i> Daftar Jemaat
                    </h6>
                    <span class="badge badge-primary px-3 py-2">
                        Total: {{ number_format($total) }} records
                    </span>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive p-4" style="overflow-x:auto; overflow-y:auto;">
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
                                <th>Tgl Terdaftar</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                                <tr onclick="window.location='{{ route('administrasi.data-jemaat.show', $item->id_jemaat) }}';" style="cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#f0f4ff'" onmouseout="this.style.background='transparent'">
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
                                                <i class="fas fa-mars me-1"></i>Laki-Laki
                                            </span>
                                        @elseif($item->gender === 'P')
                                            <span class="badge badge-danger" style="font-size: 0.75rem;">
                                                <i class="fas fa-venus me-1"></i>Perempuan
                                            </span>
                                        @else
                                            <span class="badge badge-secondary" style="font-size: 0.75rem;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->hubunganKeluarga?->kkJemaat?->id_group_wilayah)
                                            <span class="badge badge-outline-primary px-2 py-1"
                                                  style="border: 1.5px solid #5e72e4; color: #5e72e4; background: rgba(94,114,228,0.08); font-size: 0.75rem;">
                                                Wilayah {{ $item->hubunganKeluarga->kkJemaat->id_group_wilayah }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-left" style="max-width: 400px; white-space: normal; word-wrap: break-word;">
                                        {{ $item->hubunganKeluarga?->kkJemaat?->alamat ?? '-' }}
                                    </td>
                                    <td>
                                        @if($item->telepon)
                                            <a href="tel:{{ $item->telepon }}" class="text-decoration-none text-dark">
                                                <i class="fas fa-phone-alt text-success me-1" style="font-size: 0.7rem;"></i>{{ $item->telepon }}
                                            </a>
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
                                    <td colspan="9" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                            <h6 class="text-muted mb-1">Tidak ada data ditemukan</h6>
                                            <p class="text-muted mb-0" style="font-size: 0.8rem;">
                                                Belum ada data jemaat untuk periode yang dipilih.
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
                            <i class="fas fa-check-circle me-1"></i>
                            {{ number_format($total) }} records
                        </span>
                    </div>
                @endif
            </div>
        </div>

    @include('layouts.footers.auth.footer')
    </div>

@endsection