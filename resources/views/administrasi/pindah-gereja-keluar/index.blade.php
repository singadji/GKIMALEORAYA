
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

    @php use Carbon\Carbon; @endphp

    <div class="container-fluid mt--6">

        <div class="card mb-4" style="background: linear-gradient(135deg, #7c2d12 0%, #c2410c 50%, #ea580c 100%); border-radius: 12px; border: none;">
            <div class="card-body py-4 px-5">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="text-white mb-1" style="font-weight: 700; letter-spacing: 0.5px;">
                            <i class="fas fa-sign-out-alt me-2"></i>Atestasi Keluar Pindah
                        </h3>
                        <p class="text-white-50 mb-0" style="font-size: 0.9rem;">
                            Kelola data atestasi keluar pindah jemaat GKI Maleo Raya
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

        <div class="card mb-10">
            <div class="card-header mb-0">
                <h3>Data Atestasi Keluar Pindah</h3>
            </div>
            <br>
            <div class="">
                <div id="alert">
                    @include('includes.alert')
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-4">
                <table data-excluded-columns="0,1,2,3,4" style="line-height: 1.3; width:100%;color:#333333;" class="display table align-items-center mb-2 table-hover data-table nowrap" id="dataTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">N I A</th>
                                <th class="">Nama Jemaat</th>
                                <th class="">L/P</th>
                                <th class="">Tanggal Pindah</th>
                                <th class="">Gereja Tujuan</th>
                                <th class="">Pindah / Atestasi Keluar</th>
                                <th class="">Status</th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($data as $item)
                            <tr>
                                <td class="align-middle text-left">{{$no}}.</td>
                                <td class="align-middle text-left">{{ $item->nia ?? '-' }}</td>
                                <td class="align-middle text-left">{{ $item->nama_jemaat ?? '-' }}</td>
                                <td class="align-middle text-center">
                                    @if($item->gender == 'L')
                                        L
                                    @elseif($item->gender == 'P')
                                        P
                                    @else
                                        {{ $item->gender ?? '-' }}
                                    @endif
                                </td>
                                <td class="align-middle text-left">{{ $item->tanggal ? Carbon::parse($item->tanggal)->translatedFormat('d F Y') : '-' }}</td>
                                <td class="align-middle text-left">{{ $item->gereja ?? '-' }}</td>
                                <td class="align-middle text-center">
                                    @if($item->sumber == 'Pindah')
                                        <span class="badge bg-info">{{ $item->sumber }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $item->sumber }}</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    @if($item->setuju == 1)
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    @if($item->setuju != 1)
                                    <form action="{{ route('administrasi.pindah-gereja-keluar.setuju', $item->id_pindah_gereja) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-link text-success px-1 mb-0" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <a class="btn btn-link text-dark px-1 mb-0" href="{{ route('administrasi.pindah-gereja-keluar.edit', $item->id_pindah_gereja) }}">
                                        <i class="fas fa-pencil-alt text-dark me-1" aria-hidden="true"></i>
                                    </a>
                                    <a class="btn btn-link text-primary px-1 mb-0" href="{{ route('administrasi.pindah-gereja-keluar.cetak', $item->id_pindah_gereja) }}" target="_blank" title="Cetak Surat">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <form action="{{ route('administrasi.pindah-gereja-keluar.destroy', $item->id_pindah_gereja) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger px-1 mb-0" title="Hapus" onclick="return confirm('{{ $text }}')">
                                            <i class="far fa-trash-alt me-1"></i>
                                        </button>
                                    </form>
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
