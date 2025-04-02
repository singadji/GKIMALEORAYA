
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
                                <th class="text-uppercase font-weight-bolder ps-2">Nama Jemaat</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Alamat Domisili</th>
                                <th class="text-uppercase font-weight-bolder ps-2">No. Telepon/HP</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Status Keanggotaan</th>
                                <!-- <th class=""></th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($item as $item)
                                @php
                                    // Cek apakah jemaat adalah kepala keluarga (memiliki data di kk_jemaat)
                                    $isKK = $item->kkJemaat ? true : false;
                                @endphp
                                <tr onclick="window.location='{{ route('administrasi.data-jemaat.show', $item->id_jemaat) }}';" style="cursor: pointer;">
                                    <td class="align-middle">{!! $isKK ? '<strong>' . $no . '.</strong>' : $no . '.' !!}</td>
                                    <td class="text-center font-weight-bold" width="30px" style="word-wrap: break-word; white-space: normal !important;">
                                        {!! $isKK ? '<strong>' . $item->nia . '</strong>' : $item->nia !!}
                                    </td>
                                    <td class="align-left">
                                        {!! $isKK ? '<strong>' . $item->nama_jemaat . '</strong>' : $item->nama_jemaat !!}
                                        @if($item->status_aktif == "Meninggal Dunia")
                                            <sup><i class="fa fa-solid fa-cross" style="color:purple;"></i></sup>
                                        @endif
                                        @if($item->status_aktif == "Atestasi")
                                            <sup><i class="fa fa-solid fa-share" style="color:red"></i></sup>
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        @if ($isKK)
                                            <strong>{{ $item->kkJemaat->alamat }}</strong> <!-- Alamat dari KK Jemaat -->
                                        @elseif ($item->hubunganKeluarga && $item->hubunganKeluarga->kkJemaat)
                                            {{ $item->hubunganKeluarga->kkJemaat->alamat }} <!-- Alamat dari Hubungan Keluarga -->
                                        @else
                                            Tidak Diketahui
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {!! $isKK ? '<strong>' . $item->telepon . '</strong>' : $item->telepon !!}
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $badgeClass = $item->status_aktif == 'Aktif' ? 'bg-gradient-success' :
                                                        ($item->status_aktif == 'Meninggal Dunia' ? 'bg-gradient-purple' : 'bg-gradient-danger');
                                        @endphp
                                        <span class="badge {{ $badgeClass }} text-white">{!! $isKK ? '<strong>' . $item->status_aktif . '</strong>' : $item->status_aktif !!}</span>
                                    </td>
                                    <!-- <td class="align-middle text-center">
                                        <a class="btn btn-link text-dark px-1 mb-0" href="{{ route('administrasi.data-jemaat.edit', $item->id_jemaat) }}">
                                            <i class="fas fa-pencil-alt text-dark me-1" aria-hidden="true"></i>
                                        </a>
                                        <a class="btn btn-link text-danger text-gradient px-1 mb-0" data-confirm-delete="true" href="{{ route('administrasi.data-jemaat.destroy', $item->id_jemaat) }}">
                                            <i class="far fa-trash-alt me-1"></i>
                                        </a>
                                    </td> -->
                                </tr>
                                @php $no++; @endphp
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