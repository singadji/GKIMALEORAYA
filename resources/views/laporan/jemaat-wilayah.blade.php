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
        <br>

        <div>
            <div id="alert">
                @include('includes.alert')
            </div>
        </div>

        {{-- 🔽 Dropdown Wilayah --}}
        <div class="px-4 mb-3">
            <form method="GET" id="wilayahForm">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <label for="wilayah_id" class="form-label fw-bold">Pilih Wilayah:</label>
                        <select id="wilayah_id" name="wilayah_id" class="form-control"
                            onchange="window.location.href='{{ url('laporan/jemaat-wilayah') }}/' + this.value;">
                            <option value="">-- Pilih Wilayah --</option>
                            @foreach ($wilayah as $item)
                                <option value="{{ $item->id_group_wilayah }}"
                                    {{ $wilayahId == $item->id_group_wilayah ? 'selected' : '' }}>
                                    Wilayah {{ $item->id_group_wilayah }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>

        {{-- 🔽 Tabel Data Jemaat --}}
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-4" style="overflow-x:auto; overflow-y:auto;">
                <table class="display table align-items-center mb-2 table-hover data-table" id="dataTable"
                       style="line-height: 1.3; width:100%; color:#333333;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIA</th>
                            <th>Nama Jemaat</th>
                            <th>L/P</th>
                            <th>Wilayah</th>
                            <th>Tgl Lahir</th>
                            <th>Tgl Baptis</th>
                            <th>Tgl Sidi</th>
                            <th>Status Nikah</th>
                            <th>Tgl Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse($data as $item)
                           <tr onclick="window.open('{{ route('administrasi.data-jemaat.show', $item->id_jemaat) }}', '_blank');" style="cursor: pointer;">
                                <td>{{ $no++ }}</td>
                                <td class="fw-bold text-center">{{ $item->nia }}</td>
                                <td>{{ $item->nama_jemaat }}</td>
                                <td>{{ $item->gender }}</td>
                                <td>{{ $item->id_group_wilayah ?? 'Wilayah '.$item->id_group_wilayah }}</td>
                                <td>{{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->translatedFormat('d F Y') : '-'  }}</td>
                                <td>{{ ($item->tanggal_baptis && $item->tanggal_baptis != '1900-01-01') ? \Carbon\Carbon::parse($item->tanggal_baptis)->translatedFormat('d F Y') : '-'  }}</td>
                                <td>{{ ($item->tanggal_sidi && $item->tanggal_sidi != '1900-01-01') ? \Carbon\Carbon::parse($item->tanggal_sidi)->translatedFormat('d F Y') : '-'  }}</td>
                                <td>{{ $item->status_menikah }}</td>
                                <td>{{ $item->tanggal_terdaftar ? \Carbon\Carbon::parse($item->tanggal_terdaftar)->translatedFormat('d F Y') : '-'  }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-danger">
                                    @if($wilayahId)
                                        Tidak ada data jemaat di wilayah ini.
                                    @else
                                        Silakan pilih wilayah terlebih dahulu.
                                    @endif
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