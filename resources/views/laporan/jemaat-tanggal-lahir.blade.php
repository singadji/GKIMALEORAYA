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
    <div class="card mb-10">
        <div class="card-header mb-0">
            <h1>{!! $Hjudul !!}</h1>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('laporan.jemaat-tanggal-lahir') }}" class="mb-4">
                <div class="row">
        <div class="col-md-2">
            <label>Bulan Awal</label>
            <select name="bulan_awal" class="form-control from-control-sm">
                @for($i=1; $i<=12; $i++)
                    <option value="{{ $i }}"
                        {{ request('bulan_awal') == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-2">
            <label>Tanggal Awal</label>
            <select name="hari_awal" class="form-control from-control-sm">
                @for($i=1; $i<=31; $i++)
                    <option value="{{ $i }}"
                        {{ request('hari_awal') == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-2">
            <label>Bulan Akhir</label>
            <select name="bulan_akhir" class="form-control from-control-sm">
                @for($i=1; $i<=12; $i++)
                    <option value="{{ $i }}"
                        {{ request('bulan_akhir') == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-2">
            <label>Tanggal Akhir</label>
            <select name="hari_akhir" class="form-control from-control-sm">
                @for($i=1; $i<=31; $i++)
                    <option value="{{ $i }}"
                        {{ request('hari_akhir') == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-2 mt-3"><br>
            <button class="btn btn-primary w-100 btn-sm">Tampilkan</button>
        </div>
    </div>
            </form>

            <div class="table-responsive p-4" style="overflow-x:auto; overflow-y:auto;">
                <table class="display table align-items-center mb-2 table-hover data-table" id="dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIA</th>
                            <th>Nama Jemaat</th>
                            <th>L/P</th>
                            <th>Wilayah</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Tanggal Lahir</th>
                            <th>Tanggal Terdaftar</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($data as $item)
                            <tr
                                @if(!empty($item->id_jemaat))
                                    onclick="window.open(
                                        '{{ route('administrasi.data-jemaat.show', ['data_jemaat' => $item->id_jemaat]) }}',
                                        '_blank'
                                    )"
                                    style="cursor:pointer;"
                                @endif
                                >
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nia }}</td>
                                <td>{{ $item->nama_jemaat }}</td>
                                <td>{{ $item->gender }}</td>
                                <td>{{ $item->id_group_wilayah ?? '-' }}</td>
                                <td class="text-left" style="max-width: 500px; white-space: normal; word-wrap: break-word;">{{ $item->alamat ?? '-' }}</td>
                                <td>{{ $item->telepon ?? '-' }}</td>
                                <td>{{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td>
                                <td>{{ $item->tanggal_terdaftar ? \Carbon\Carbon::parse($item->tanggal_terdaftar)->translatedFormat('d F Y') : '-' }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth.footer')
</div>

@endsection