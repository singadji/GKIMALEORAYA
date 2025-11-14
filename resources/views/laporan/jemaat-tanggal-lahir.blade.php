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
                    <div class="col-md-4">
                        <label for="tanggal_awal">Tanggal Lahir Awal</label>
                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control"
                            value="{{ request('tanggal_awal') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal_akhir">Tanggal Lahir Akhir</label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control"
                            value="{{ request('tanggal_akhir') }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
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
                            <tr onclick="window.open('{{ route('administrasi.data-jemaat.show', $item->id_jemaat) }}', '_blank');" style="cursor: pointer;">
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