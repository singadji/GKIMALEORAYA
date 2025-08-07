
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
                <h3>Administrasi Data Jemaat</h3>
            </div>
            <br>
            <div class="">
                <div id="alert">
                    @include('includes.alert')
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-4" style="overflow-x:auto; overflow-y:auto;"  id="DW">
                <table data-excluded-columns="0" style="line-height: 1.3; width:100%; color:#333333;" class="display table align-items-center mb-2 table-hover data-table nowrap" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase font-weight-bolder" width="10">#</th>
                                <th class="text-uppercase font-weight-bolder" width="30px">N I A</th>
                                <th class="text-uppercase font-weight-bolder" width="30px" style="display: none;">Tanggal<br>Terdaftar</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Nama Jemaat</th>
                                <th class="text-uppercase font-weight-bolder ps-2">L/P</th>
                                <th class="text-uppercase font-weight-bolder ps-2" style="display: none;">Tempat</th>
                                <th class="text-uppercase font-weight-bolder ps-2" style="display: none;"><br>Tanggal Lahir</th>
                                <th class="text-uppercase font-weight-bolder ps-2" style="display: none;"><br>Tanggal Baptis</th>
                                <th class="text-uppercase font-weight-bolder ps-2" style="display: none;"><br>Tanggal Sidi</th>
                                <th class="text-uppercase font-weight-bolder ps-2" style="display: none;"><br>Tanggal Nikah</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Alamat Domisili</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Wil.</th>
                                <th class="text-uppercase font-weight-bolder ps-2" style="display: none;">Asal Gereja</th>
                                <th class="text-uppercase font-weight-bolder ps-2">No. Telepon/HP</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Status<br>Keanggotaan</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Keterangan</th>
                                <!-- <th class=""></th> -->
                            </tr>
                        </thead>
                    <tbody>
                        @foreach($jemaatList as $item)
                            <x-jemaat-table-row :item="$item" :loop="$loop" />
                        @endforeach
                    </tbody>
                </table>
                    <p style="font-size:10pt; color:red">*cetak tebal adalah Kepala Keluarga</p>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

    <script>
        document.getElementById('importLink').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('file').click();
        });

        document.getElementById('file').addEventListener('change', function () {
            if (this.files.length > 0) {
                document.getElementById('formImport').submit();
            }
        });
    </script>
@endsection