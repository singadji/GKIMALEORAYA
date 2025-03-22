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

    <div class="container-fluid mt--6">
        <div class="card mb-10">
            <div class="card-header mb-0">
                <h3>Detail Data Jemaat</h3>
            </div>
            <br>
            <div class="">
                <div id="alert">
                    @include('includes.alert')
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-4" style="overflow-x:auto; overflow-y:auto;"  id="DW">
                <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <strong>Data Kepala Keluarga</strong>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Nama Kepala Keluarga</th>
                    <td><strong>{{ $kepalaKeluarga->jemaat->nama_jemaat ?? 'Tidak Diketahui' }}</strong></td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $kepalaKeluarga->alamat ?? 'Tidak Diketahui' }}</td>
                </tr>
                <tr>
                    <th>Status Keanggotaan</th>
                    <td>{{ $kepalaKeluarga->jemaat->status_aktif ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- 🔹 Bagian Anggota Keluarga -->
    <div class="card">
        <div class="card-header bg-success text-white">
            <strong>Detail Anggota Keluarga</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Jemaat</th>
                        <th>Hubungan</th>
                        <th>Status Keanggotaan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($anggotaKeluarga as $key => $anggota)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $anggota->jemaat->nama_jemaat ?? 'Tidak Diketahui' }}</td>
                        <td>{{ $anggota->hubungan_keluarga }}</td>
                        <td>{{ $anggota->jemaat->status_aktif ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection