
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
                                <th class="text-uppercase font-weight-bolder ps-2" style="display: none;">Tempat,<br>Tanggal Lahir</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Alamat Domisili</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Wil.</th>
                                <th class="text-uppercase font-weight-bolder ps-2">No. Telepon/HP</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Status<br>Keanggotaan</th>
                                <!-- <th class=""></th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item as $item)
                            <tr onclick="window.location='{{ route('administrasi.data-jemaat.show', $item['id_jemaat']) }}';" style="cursor: pointer;">
                                <td class="align-middle">{!! $item['is_kk'] ? '<strong>' . $item['no'] . '.</strong>' : $item['no'] . '.' !!}</td>
                                <td class="text-center font-weight-bold" width="30px">{{ $item['nia'] }}</td>
                                <td style="display: none;">{{ $item['tanggal_terdaftar'] }}</td>
                                <td class="align-left">
                                    {!! $item['is_kk'] ? '<strong>' . $item['nama_jemaat'] . '</strong>' : $item['nama_jemaat'] !!}
                                    @if ($item['status_icon'] == 'cross')
                                        <sup><i class="fa fa-solid fa-cross" style="color:purple;"></i></sup>
                                    @elseif ($item['status_icon'] == 'share')
                                        <sup><i class="fa fa-solid fa-share" style="color:red;"></i></sup>
                                    @endif
                                </td>
                                <td class="align-left">{{ $item['gender'] }}</td>
                                <td style="display: none;">{{ $item['tempat_tanggal_lahir'] }}</td>
                                <td class="text-left">{{ $item['alamat'] }}</td>
                                <td class="align-left">{{ $item['wilayah'] }}</td>
                                <td class="text-center">{{ $item['telepon'] }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $item['badge_class'] }} text-white">
                                        {!! $item['is_kk'] ? '<strong>' . $item['status_aktif'] . '</strong>' : $item['status_aktif'] !!}
                                    </span>
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