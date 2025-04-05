
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
            <h3>Input Data Jemaat Baru</h3>
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
                <!-- Data Kepala Keluarga -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white p-2">
                        <strong>Data Kepala Keluarga</strong>
                    </div>
                    <div class="card-body table-responsive">
                            <table class="table table-hover data-table wrap">
                                <tr>
                                    <th>Nomor Induk Anggota <span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text" required id="nia" name="nia_kk" value="{{ old('nia_kk') }}" placeholder="N I A" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <th width="20px">Nama Kepala Keluarga<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text" required name="kepala_keluarga" value="{{ old('nama_jemaat') }}" placeholder="Kepala Keluarga" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <th width="20px">L / P<span class="text-danger">*</span></th>
                                    <td>
                                        <select name="p_l_kk" class="form-control form-control-sm select2" data-toggle="select" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="P">Perempuan</option>
                                            <option value="L">Laki-laki</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Alamat<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text" required name="alamat" value="{{ old('alamat') }}" placeholder="Alamat" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nomor Telepon / HP<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="text" required name="telepon_kk" value="{{ old('telepon') }}" placeholder="Telepon" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tempat, Tanggal Lahir<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="text" required name="tempat_lahir_kk" value="{{ old('tempat_lahir') }}"
                                                    placeholder="Tempat Lahir" class="form-control form-control-sm"
                                                   >
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" required name="tanggal_lahir_kk" value="{{ old('tanggal_lahir') }}"
                                                    class="form-control form-control-sm"
                                                   >
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Baptis<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="date" name="tanggal_baptis_kk" value="{{ old('tanggal_baptis') }}" placeholder="Tanggal Baptis" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Sidi<span class="text-danger">*</span></th>
                                    <td>
                                        <input type="date"  name="tanggal_sidi_kk" value="{{ old('tanggal_sidi') }}" placeholder="Tanggal Sidi" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status dan Tanggal Pernikahan<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select class="form-control-sm select2" required data-toggle="select" name="status_menikah_kk">
                                                    <option>--pilih--</option>
                                                    <option value="Belum Menikah">Belum Menikah </option>
                                                    <option value="Menikah">Menikah</option>
                                                    <option value="Duda">Duda</option>
                                                    <option value="Janda">Janda</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" name="tanggal_nikah_kk" value="{{ old('tanggal_nikah') }}" placeholder="Tanggal Nikah" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Gereja Asal dan Tanggal Terdaftar</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" required name="asal_gereja_kk" value="{{ old('asal_gereja') }}" placeholder="Gereja Asal" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" required name="tanggal_terdaftar_kk" value="{{ old('tanggal_terdaftar') }}" placeholder="Tanggal Terdaftar" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Grup Wilayah</th>
                                    <td>
                                        <input type="text" required name="group_wilayah_kk" value="{{ old('id_group_wilayah') }}" placeholder="" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Keanggotaan<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row" id="status-row">
                                            <div class="col-md-6">
                                                <select class="form-control-sm select2" required data-toggle="select" name="status_aktif_kk">
                                                    <option>--pilih--</option>
                                                    <option value="Aktif">Aktif</option>
                                                    <option value="Atestasi">Atestasi</option>
                                                    <option value="Meninggal Dunia">Meninggal Dunia</option>
                                                    <option value="Tidak Tahu">Tidak Tahu</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" placeholder="Atestasi ke Gereja tujuan" name="keterangan_kk" value="{{ old('keterangan') }}" class="form-control form-control-sm">
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
                                    <th class="text-center">N I A<span class="text-danger">*</span></th>
                                    <th class="text-center">Nama Jemaat<span class="text-danger">*</span></th>
                                    <th class="text-center">P / L<span class="text-danger">*</span></th>
                                    <th class="text-center">Hubungan<span class="text-danger">*</span></th>
                                    <th class="text-center">Tempat<br>Lahir</th>
                                    <th class="text-center">Tanggal<br>Lahir<span class="text-danger">*</span></th>
                                    <th class="text-center">Tanggal<br>Baptis</th>
                                    <th class="text-center">Tanggal<br>Sidi</th>
                                    <th class="text-center">Gereja Asal</th>
                                    <th class="text-center">Tanggal<br>Terdaftar</th>
                                    <th class="text-center">Status<br>Keanggotaan<span class="text-danger">*</span></th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center" hidden></th>
                                </tr>
                            </thead>
                            <tbody>
                                    
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="simpan" class="btn btn-warning bg-gradient-warning btn-md"> Simpan </button>
                        <p class="p-4"><span class="text-danger">* Harus disi dengan lengkap.</span></p>
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
            <td>
                <select class="form-control form-control-sm select2" data-toggle="select" required name="p_l[]">
                        <option value="">-- Pilih --</option>
                        <option value="P">Perempuan</option>
                        <option value="L">Laki-laki</option>
                    </select>
            </td>
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
            <td><input type="date" class="form-control form-control-sm" name="tanggal_baptis[]"></td>
            <td><input type="date" class="form-control form-control-sm" name="tanggal_sidi[]"></td>
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
            $(this).find("td:first").text(index);
        });
    }
});
</script>

@endsection

