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
            <div class="">
                <div id="alert">
                    @include('includes.alert')
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-4" style="overflow-x:auto; overflow-y:auto;"  id="DW">
                    <table data-excluded-columns="0" style="line-height: 1.3; width:100%; color:#333333;" class="display table align-items-center mb-2 table-hover data-table" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase font-weight-bolder" width="10">#</th>
                                <th class="text-uppercase font-weight-bolder" width="30px">N I A</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Nama Jemaat</th>
                                <th class="text-uppercase font-weight-bolder ps-2">L/P</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Wil.</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Alamat</th>
                                <th class="text-uppercase font-weight-bolder ps-2">No. Telepon/HP</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Tanggal Meninggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                                
                                <tr onclick="window.location='{{ route('administrasi.data-jemaat.show', $item->id_jemaat) }}';" style="cursor: pointer;">
                                    <td>{{ $loop->iteration }}</td>
    <td>{{ $item->jemaat->nia }}</td>
    <td>{{ $item->jemaat->nama_jemaat ?? '-' }}</td>
    <td>{{ $item->jemaat->gender }}</td>
    
    <td>
        {{ $item->jemaat->hubunganKeluarga->kkJemaat->id_group_wilayah ?? '-' }}
    </td>
    
    <td style="max-width: 250px; white-space: normal;">
        {{ $item->jemaat->kkJemaat->alamat 
        ?? $item->jemaat->hubunganKeluarga->kkJemaat->alamat 
        ?? '-' }}
    </td>
    
    <td class="text-center">
        {{ $item->jemaat->telepon ?? '-' }}
    </td>
    
    <td class="text-center">
        {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') : '-' }}
    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p style="font-size:10pt; color:red">*cetak tebal adalah Kepala Keluarga</p>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection