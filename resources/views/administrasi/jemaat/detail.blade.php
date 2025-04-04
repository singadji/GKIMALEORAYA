
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

            @if(isset($anggotaKeluarga))
                <span id="batal" @if(!isset($edit)) @endif>
                    <a class="btn btn-default text-white bg-gradient-default btn-sm mt-3 ms-auto batal"
                       id="btl" name="batal" value="Batal">Batal</a>
                </span>
                <span id="edit">
                    <a class="btn btn-default text-white bg-gradient-default btn-sm mt-3 ms-auto edit"
                       id="edt" name="edit" value="Ubah Data">Ubah Data</a>
                </span>
                <!-- <span id="hapus">
                    <a data-confirm-delete="true" href="{{ route('administrasi.data-jemaat.destroy', $id_kk) }}"
                       class="btn btn-danger bg-gradient-danger btn-sm mt-3 ms-auto">Hapus</a>
                </span> -->
            @endif
        </div>

        <br>

        <div>
            <div id="alert">
                @include('includes.alert')
            </div>
        </div>

        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-4" style="overflow-x:auto; overflow-y:auto;" id="DW">
                <form role="form" method="POST" action="{{ $aksi }}" enctype="multipart/form-data">
                            @csrf
                            @if(isset($anggotaKeluarga))
                                @method('PUT')
                            @endif
                <!-- Data Kepala Keluarga -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white p-2">
                        <strong>Data Kepala Keluarga</strong>
                    </div>
                    <div class="card-body table-responsive">
                            <table class="table table-hover data-table wrap">
                                <tr>
                                    <th>Nomor Induk Anggota</th>
                                    <td>
                                        <input type="text" required id="nia" name="nia_kk" value="{{ $kepalaKeluarga->jemaatKK->nia ?? 'Tidak Diketahui' }}" placeholder="N I A" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        <input type="hidden" name="id_kk" value="{{ $id_kk }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th width="20px">Nama Kepala Keluarga</th>
                                    <td>
                                        <input type="text" required id="ubahdata" name="kepala_keluarga" value="{{ $kepalaKeluarga->jemaatKK->nama_jemaat ?? 'Tidak Diketahui' }}" placeholder="Kepala Keluarga" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="20px">P / L</th>
                                    <td>
                                        <input type="text" required id="ubahdata" name="p_l_kk" value="{{ $kepalaKeluarga->jemaatKK->gender ?? 'Tidak Diketahui' }}" placeholder="" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>
                                        <input type="text" required id="ubahdata" name="alamat" value="{{ $kepalaKeluarga->alamat ?? 'Tidak Diketahui' }}" placeholder="Alamat" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nomor Telepon / HP</th>
                                    <td>
                                        <input type="text" required id="ubahdata" name="telepon_kk" value="{{ $kepalaKeluarga->jemaatKK->telepon ?? '-' }}" placeholder="Telepon" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tempat, Tanggal Lahir</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="text" required name="tempat_lahir_kk" value="{{ $kepalaKeluarga->jemaatKK->tempat_lahir ?? '-' }}"
                                                    placeholder="Tempat Lahir" class="form-control form-control-sm"
                                                    {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" required name="tanggal_lahir_kk" value="{{ $kepalaKeluarga->jemaatKK->tanggal_lahir ?? '-' }}"
                                                    class="form-control form-control-sm"
                                                    {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Baptis</th>
                                    <td>
                                        <input type="date" id="ubahdata" name="tanggal_baptis_kk" value="{{ $kepalaKeluarga->jemaatKK->tanggal_baptis ?? '-' }}" placeholder="Tanggal Baptis" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Sidi</th>
                                    <td>
                                        <input type="date" id="ubahdata" name="tanggal_sidi_kk" value="{{ $kepalaKeluarga->jemaatKK->tanggal_sidi ?? '-' }}" placeholder="Tanggal Sidi" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status dan Tanggal Pernikahan</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select class="form-control-sm select2" required data-toggle="select" name="status_menikah_kk" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                    <option>--pilih--</option>
                                                    <option @if($kepalaKeluarga->jemaatKK->status_menikah == 'Belum Menikah') selected @endif value="Belum Menikah">Belum Menikah </option>
                                                    <option @if($kepalaKeluarga->jemaatKK->status_menikah == 'Menikah') selected @endif value="Menikah">Menikah</option>
                                                    <option @if($kepalaKeluarga->jemaatKK->status_menikah == 'Duda') selected @endif value="Duda">Duda</option>
                                                    <option @if($kepalaKeluarga->jemaatKK->status_menikah == 'Janda') selected @endif value="Janda">Janda</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" id="ubahdata" name="tanggal_nikah_kk" value="{{ $kepalaKeluarga->jemaatKK->tanggal_nikah ?? '-' }}" placeholder="Tanggal Nikah" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Gereja Asal dan Tanggal Terdaftar</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" required id="ubahdata" name="asal_gereja_kk" value="{{ $kepalaKeluarga->jemaatKK->asal_gereja ?? '-' }}" placeholder="Gereja Asal" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" required id="ubahdata" name="tanggal_terdaftar_kk" value="{{ $kepalaKeluarga->jemaatKK->tanggal_terdaftar ?? '-' }}" placeholder="Tanggal Terdaftar" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Grup Wilayah</th>
                                    <td>
                                        <input type="text" required id="ubahdata" name="group_wilayah_kk" value="{{ $kepalaKeluarga->id_group_wilayah ?? '-' }}" placeholder="" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Keanggotaan</th>
                                    @php
                                        $badgeClass = $kepalaKeluarga->jemaatKK->status_aktif == 'Aktif' ? 'bg-gradient-success' :
                                                    ($kepalaKeluarga->jemaatKK->status_aktif == 'Meninggal Dunia' ? 'bg-gradient-primary' : 'bg-gradient-danger');
                                    @endphp
                                    <td>
                                        <span id="status-keanggotaan-row" class="badge {{ $badgeClass }} text-white" style="font-size:9pt">
                                            {{ $kepalaKeluarga->jemaatKK->status_aktif ?? '-' }} - {{ $kepalaKeluarga->jemaatKK->keterangan ?? '' }}
                                        </span>
                                        <div class="row" id="status-row" style="display: none;">
                                            <div class="col-md-6">
                                                <select class="form-control-sm select2" required data-toggle="select" name="status_aktif_kk" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                    <option>--pilih--</option>
                                                    <option @if($kepalaKeluarga->jemaatKK->status_aktif == 'Aktif') selected @endif value="Aktif">Aktif</option>
                                                    <option @if($kepalaKeluarga->jemaatKK->status_aktif == 'Atestasi') selected @endif value="Atestasi">Atestasi</option>
                                                    <option @if($kepalaKeluarga->jemaatKK->status_aktif == 'Meninggal Dunia') selected @endif value="Meninggal Dunia">Meninggal Dunia</option>
                                                    <option @if($kepalaKeluarga->jemaatKK->status_aktif == 'Tidak Tahu') selected @endif value="Tidak Tahu">Tidak Tahu</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" placeholder="Atestasi ke Gereja tujuan" name="keterangan_kk" value="{{ $kepalaKeluarga->jemaatKK->keterangan ?? '' }}" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                    </div>
                </div>

                <!-- Detail Anggota Keluarga -->
                <div class="card">
                    <div class="card-header bg-success text-white p-2">
                        <strong>Detail Anggota Keluarga</strong>
                    </div>
                    <div class="card-body table-responsive">
                        <a href="#" id="addRow" class="btn btn-primary mb-2 btn-sm">Tambah Anggota Keluarga</a>
                        <table class="table table-bordered table-hover data-table warping" id="tableBody">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">N I A</th>
                                    <th class="text-center">Nama Jemaat</th>
                                    <th class="text-center">P / L</th>
                                    <th class="text-center">Hubungan</th>
                                    <th class="text-center">Tempat<br>Lahir</th>
                                    <th class="text-center">Tanggal<br>Lahir</th>
                                    <th class="text-center">Tanggal<br>Baptis</th>
                                    <th class="text-center">Tanggal<br>Sidi</th>
                                    <th class="text-center">Gereja Asal</th>
                                    <th class="text-center">Tanggal<br>Terdaftar</th>
                                    <th class="text-center">Status<br>Keanggotaan</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center" hidden></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($anggotaKeluarga as $key => $anggota)
                                    @php
                                        $badgeClass = $anggota->jemaat->status_aktif == 'Aktif' ? 'bg-gradient-success' :
                                                    ($anggota->jemaat->status_aktif == 'Meninggal Dunia' ? 'bg-gradient-primary' : 'bg-gradient-danger');
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $key+1 }}</td>
                                        <td>
                                            <input type="text" required id="nia" style="width:70px;" name="nia_anggota[]" value="{{ $anggota->jemaat->nia ?? 'Tidak Diketahui' }}" placeholder="NIA" class="form-control form-control-sm nia" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        </td>
                                        <td>
                                            <input type="text" required id="ubahdata" style="width:150px;" name="nama_jemaat[]" value="{{ $anggota->jemaat->nama_jemaat ?? 'Tidak Diketahui' }}" placeholder="Nama Jemaat" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        </td>
                                        <td>
                                            <input type="text" required id="ubahdata" style="width:30px;" name="p_l[]" value="{{ $anggota->jemaat->gender ?? 'Tidak Diketahui' }}" placeholder="P / L" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <select class="form-control-sm select2" required data-toggle="select" name="hubungan_keluarga[]" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                <option>--pilih--</option>
                                                <option value="Kepala Keluarga" 
                                                    {{ ( optional($anggota)->hubungan_keluarga != 'Kepala Keluarga') ? 'selected' : '' }}>
                                                    Kepala Keluarga
                                                </option>
                                                <option value="Pasangan" 
                                                    {{ ( optional($anggota)->hubungan_keluarga == 'Pasangan') ? 'selected' : '' }}>
                                                    Pasangan
                                                </option>
                                                <option value="Anak" 
                                                    {{ ( optional($anggota)->hubungan_keluarga == 'Anak') ? 'selected' : '' }}>
                                                    Anak
                                                </option>
                                                <option value="Kerabat" 
                                                    {{ ( optional($anggota)->hubungan_keluarga == 'Kerabat') ? 'selected' : '' }}>
                                                    Kerabat
                                                </option>
                                                <option value="Belum Menikah" 
                                                    {{ ( optional($anggota)->hubungan_keluarga == 'Belum Menikah') ? 'selected' : '' }}>
                                                    Belum Menikah
                                                </option>
                                            </select>    
                                        </td>
                                        <td class="text-center">
                                            <input type="text" required id="ubahdata" style="width:150px;" name="tempat_lahir[]" value="{{ $anggota->jemaat->tempat_lahir ?? 'Tidak Diketahui' }}" placeholder="Tempat Lahir" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input type="date" required id="ubahdata" style="width:120px;"  name="tanggal_lahir[]" value="{{ $anggota->jemaat->tanggal_lahir ?? 'Tidak Diketahui' }}" placeholder="Tanggal Lahir" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input type="date" id="ubahdata" style="width:120px;"  name="tanggal_baptis[]" value="{{ $anggota->jemaat->tanggal_baptis ?? 'Tidak Diketahui' }}" placeholder="Tanggal Baptis" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input type="date" id="ubahdata" style="width:120px;"  name="tanggal_sidi[]" value="{{ $anggota->jemaat->tanggal_sidi ?? 'Tidak Diketahui' }}" placeholder="Tanggal Sidi" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        </td>
                                        <td class="text-center">
                                            <input type="text" required id="ubahdata" style="width:150px;"  name="asal_gereja[]" value="{{ $anggota->jemaat->asal_gereja ?? 'Tidak Diketahui' }}" placeholder="" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        <td class="text-center">
                                            <input type="date" required id="ubahdata" style="width:120px;"  name="tanggal_terdaftar[]" value="{{ $anggota->jemaat->tanggal_terdaftar ?? 'Tidak Diketahui' }}" placeholder="Tanggal Terdaftar" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        </td>
                                            @php
                                            $badgeClass = $anggota->jemaat->status_aktif == 'Aktif' ? 'bg-gradient-success' :
                                                    ($anggota->jemaat->status_aktif == 'Meninggal Dunia' ? 'bg-gradient-primary' : 'bg-gradient-danger');
                                            @endphp
                                        <td class="text-center">
                                            <span id="status-keanggotaan-row1" class="badge {{ $badgeClass }} text-white status-keanggotaan-row1">
                                                {{ $anggota->jemaat->status_aktif ?? '-' }}
                                            </span>
                                            <div class="row status-row1" id="status-row1" style="display: none;">
                                                <div class="col-md-6">
                                                    <select class="form-control-sm select2" required data-toggle="select" name="status_aktif[]" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                        <option>--pilih--</option>
                                                        <option @if($anggota->jemaat->status_aktif == 'Aktif') selected @endif value="Aktif">Aktif</option>
                                                        <option @if($anggota->jemaat->status_aktif == 'Atestasi') selected @endif value="Atestasi">Atestasi</option>
                                                        <option @if($anggota->jemaat->status_aktif == 'Meninggal Dunia') selected @endif value="Meninggal Dunia">Meninggal Dunia</option>
                                                        <option @if($anggota->jemaat->status_aktif == 'Tidak Tahu') selected @endif value="Tidak Tahu">Tidak Tahu</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" id="ubahdata" style="width:200px;"  name="keterangan[]" value="{{ $anggota->jemaat->keterangan ?? '' }}" placeholder="" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        </td>
                                        <td class="">
                                        <a class="btn btn-link text-danger text-gradient px-1 mb-0" data-confirm-delete="true" href="{{ route('administrasi.data-jemaat.destroy', $anggota->jemaat->id_jemaat) }}">
                                            <i class="far fa-trash-alt me-1"></i>
                                        </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="simpan" class="btn btn-warning bg-gradient-warning btn-md"> Simpan </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>

<script>
    $(document).ready(function () {
    // Event untuk menambah baris baru
    $("#addRow").click(function (e) {
        e.preventDefault(); // Mencegah default behavior dari button

        // Tambahkan baris baru dengan input
        var newRow = `<tr>
            <td class="text-center"></td>
            <td><input type="text" required style="width:70px;" name="nia_anggota[]" placeholder="NIA" class="form-control form-control-sm nia"></td>
            <td><input type="text" required class="form-control form-control-sm" name="nama_jemaat[]" placeholder="Nama Jemaat"></td>
            <td><input type="text" required class="form-control form-control-sm" name="p_l[]" placeholder="Jenis Kelamin"></td>
            <td>
                <select class="form-control-sm select2" data-toggle="select" required name="hubungan_keluarga[]">
                    <option value="Kepala Keluarga">Kepala Keluarga</option>
                    <option value="Pasangan">Pasangan</option>
                    <option value="Anak">Anak</option>
                    <option value="Kerabat">Kerabat</option>
                    <option value="Belum Menikah">Belum Menikah</option>
                </select>
            </td>
            <td><input type="text" required class="form-control form-control-sm" name="tempat_lahir[]" placeholder="Tempat Lahir"></td>
            <td><input type="date" required class="form-control form-control-sm" name="tanggal_lahir[]"></td>
            <td><input type="date"  class="form-control form-control-sm" name="tanggal_baptis[]"></td>
            <td><input type="date"  class="form-control form-control-sm" name="tanggal_sidi[]"></td>
            <td><input type="text" required class="form-control form-control-sm" name="asal_gereja[]" placeholder="Gereja Asal"></td>
            <td><input type="date" class="form-control form-control-sm" name="tanggal_terdaftar[]"></td>
            <td>
                <select class="form-control-sm select2" required name="status_aktif[]">
                    <option value="Aktif">Aktif</option>
                    <option value="Atestasi">Atestasi</option>
                    <option value="Meninggal Dunia">Meninggal Dunia</option>
                    <option value="Tidak Tahu">Tidak Tahu</option>
                </select>
            </td>
            <td><input type="text" class="form-control form-control-sm" name="keterangan[]" placeholder="Keterangan"></td>
            <td><button class="btn btn-danger btn-sm removeRow"><i class="fa fa-times"></i></button></td>
        </tr>`;

        // Append baris baru ke dalam tabel
        $("#tableBody").append(newRow);
        updateRowNumbers();

        // Reinitialize Select2 setelah baris baru ditambahkan
        $(".select2").select2({
            theme: "bootstrap-5",
            width: "100%",
        });
    });

    // Event untuk menghapus baris
    $(document).on("click", ".removeRow", function () {
        $(this).closest("tr").remove();
        updateRowNumbers();
    });

    // Update nomor urut baris
    function updateRowNumbers() {
        $("#tableBody tr").each(function (index) {
            $(this).find("td:first").text(index + 1);
        });
    }
});
</script>

<script>
    $(document).ready(function () {
        $("#btl").hide();
        $("#addRow").hide();
        $(".status-row1").hide(); 
        $(".removeRow").hide(); 
        $("#simpan").hide(); 

        $("#edt").click(function () {
            $("#status-row").show(); 
            $(".status-row1").show(); 
            $(".removeRow").show(); 
            $("#status-keanggotaan-row").hide();
            $(".status-keanggotaan-row1").hide();
            $("input, select").prop("disabled", false);
            $("#edt").hide();
            $("#btl").show();
            $("#addRow").show();
            $("#simpan").show();
        });

        $("#btl").click(function () {
            $("#status-row").hide(); 
            $(".status-row1").hide(); 
            $(".removeRow").hide(); 
            $("#status-keanggotaan-row").show();
            $(".status-keanggotaan-row1").show();
            $("input, select").prop("disabled", true);
            $("#btl").hide();
            $("#addRow").hide();
            $("#edt").show();
            $("#simpan").hide();
        });
    });
</script>

@endsection

