@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

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
        $totalJemaat = $item->count();
        $totalAktif = $item->where('status_aktif', 'Aktif')->count();
        $totalMeninggal = $item->where('status_aktif', 'Meninggal Dunia')->count();
        $totalAtestasi = $item->where('status_aktif', 'Atestasi')->count();
        $totalLaki = $item->where('gender', 'L')->count();
        $totalPerempuan = $item->where('gender', 'P')->count();
        $totalKK = $item->where('kkJemaat', '!=', null)->count();
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
                    <table class="display table align-items-center mb-2 table-hover data-table" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>N I A</th>
                                <th>Nama Jemaat</th>
                                <th class="text-center">L/P</th>
                                <th>Alamat</th>
                                <th class="text-center">Wil.</th>
                                <th class="text-center">No. Telepon/HP</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($item as $jemaat)
                                @php
                                    $isKK = $jemaat->kkJemaat ? true : false;
                                @endphp
                                <tr onclick="window.location='{{ route('administrasi.data-jemaat.show', $jemaat->id_jemaat) }}';" style="cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#f0f4ff'" onmouseout="this.style.background='transparent'">
                                    <td class="text-center text-muted">{{ $no }}</td>
                                    <td>
                                        <span class="font-weight-bold text-dark">{{ $jemaat->nia }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm rounded-circle bg-gradient-secondary text-white d-flex align-items-center justify-content-center me-2"
                                                 style="width: 32px; height: 32px; font-size: 0.75rem;">
                                                {{ strtoupper(substr($jemaat->nama_jemaat ?? 'X', 0, 1)) }}
                                            </div>
                                            <span class="font-weight-600">
                                                {{ $jemaat->nama_jemaat }}
                                                @if($jemaat->status_aktif == "Meninggal Dunia")
                                                    <sup><i class="fa fa-solid fa-cross" style="color:purple;"></i></sup>
                                                @endif
                                                @if($jemaat->status_aktif == "Atestasi")
                                                    <sup><i class="fa fa-solid fa-share" style="color:red"></i></sup>
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($jemaat->gender == 'L')
                                            <span class="badge badge-info" style="font-size: 0.75rem;">
                                                <i class="fas fa-mars me-1"></i>L
                                            </span>
                                        @elseif($jemaat->gender == 'P')
                                            <span class="badge badge-danger" style="font-size: 0.75rem;">
                                                <i class="fas fa-venus me-1"></i>P
                                            </span>
                                        @else
                                            <span class="badge badge-secondary" style="font-size: 0.75rem;">{{ $jemaat->gender }}</span>
                                        @endif
                                    </td>
                                    <td style="max-width: 300px; white-space: normal; word-wrap: break-word;">
                                        <span class="text-muted">
                                            @if ($isKK)
                                                {{ $jemaat->kkJemaat->alamat }}
                                            @elseif ($jemaat->hubunganKeluarga && $jemaat->hubunganKeluarga->kkJemaat)
                                                {{ $jemaat->hubunganKeluarga->kkJemaat->alamat }}
                                            @else
                                                Tidak Diketahui
                                            @endif
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-outline-primary px-2 py-1" style="border: 1.5px solid #5e72e4; color: #5e72e4; background: rgba(94,114,228,0.08); font-size: 0.75rem;">
                                            @if ($isKK)
                                                {{ $jemaat->kkJemaat->id_group_wilayah }}
                                            @elseif ($jemaat->hubunganKeluarga && $jemaat->hubunganKeluarga->kkJemaat)
                                                {{ $jemaat->hubunganKeluarga->kkJemaat->id_group_wilayah }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-muted">
                                            @if ($jemaat->telepon)
                                                <a href="tel:{{ $jemaat->telepon }}" class="text-decoration-none text-dark">
                                                    <i class="fas fa-phone-alt text-success me-1" style="font-size: 0.7rem;"></i>{{ $jemaat->telepon }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $badgeClass = $jemaat->status_aktif == 'Aktif' ? 'badge-info' :
                                                        ($jemaat->status_aktif == 'Meninggal Dunia' ? 'badge-purple' :
                                                        ($jemaat->status_aktif == 'Atestasi' ? 'badge-warning' : 'badge-danger'));
                                        @endphp
                                        <span class="badge {{ $badgeClass }}" style="font-size: 0.75rem;">
                                            {{ $jemaat->status_aktif }}
                                        </span>
                                    </td>
                                </tr>
                                @php $no++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

@endsection