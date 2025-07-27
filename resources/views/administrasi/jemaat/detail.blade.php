
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
                            <li> &nbsp; - {!! $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        @endsection

    <div class="container-fluid mt-6">
        <div class="card mb-10">
            <div class="card-header mb-0">
                <h3>Detail Data Jemaat</h3>

                @if(isset($anggotaKeluarga))
                <div class="d-flex align-items-center gap-2 mt-3 flex-wrap">
                    <span id="batal" @if(!isset($edit)) @endif>
                        <a class="btn btn-default text-white bg-gradient-default btn-sm batal"
                        id="btl" name="batal" value="Batal">Batal</a>
                    </span>

                    <span id="edit">
                        <a class="btn btn-default text-white bg-gradient-default btn-sm edit"
                        id="edt" name="edit" value="Ubah Data"><i class="fas fa-pencil-alt"></i> Ubah Data</a>
                    </span>
                    &nbsp;<span>
                    <a href="{{ route('administrasi.data-jemaat.cetak', $id) }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                    </span>
                </div>

                    
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
                                        <th>Nomor Induk Anggota<span class="text-danger">*</span></th>
                                        <td>
                                            <input type="text" required id="nia" name="nia_kk" value="{{ $kepalaKeluarga->jemaatKK->nia ?? 'Tidak Diketahui' }}" placeholder="N I A" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                            <input type="hidden" name="id_kk" value="{{ $id_kk }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20px">Nama Kepala Keluarga<span class="text-danger">*</span></th>
                                        <td>
                                            <input type="text" required id="ubahdata" name="kepala_keluarga" value="{{ $kepalaKeluarga->jemaatKK->nama_jemaat ?? 'Tidak Diketahui' }}" placeholder="Kepala Keluarga" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20px">L / P<span class="text-danger">*</span></th>
                                        <td>
                                            <select name="p_l_kk" id="ubahdata" class="form-control form-control-sm" required {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                <option value="L" {{ ($kepalaKeluarga->jemaatKK->gender ?? '') == 'L' ? 'selected' : '' }}>L</option>
                                                <option value="P" {{ ($kepalaKeluarga->jemaatKK->gender ?? '') == 'P' ? 'selected' : '' }}>P</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Alamat<span class="text-danger">*</span></th>
                                        <td>
                                            <input type="text" required id="ubahdata" name="alamat_kk" value="{{ $kepalaKeluarga->alamat ?? 'Tidak Diketahui' }}" placeholder="Alamat" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Telepon / HP<span class="text-danger">*</span></th>
                                        <td>
                                            <input type="text" required id="ubahdata" name="telepon_kk" value="{{ $kepalaKeluarga->jemaatKK->telepon ?? '-' }}" placeholder="Telepon" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tempat, Tanggal Lahir<span class="text-danger">*</span></th>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <input type="text" required name="tempat_lahir_kk" value="{{ $kepalaKeluarga->jemaatKK->tempat_lahir ?? '-' }}"
                                                        placeholder="Tempat Lahir" class="form-control form-control-sm"
                                                        {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                </div>
                                                <div class="col-md-4">
                                                    <input required type="text"
                                                        id="ubahdata"
                                                        name="tanggal_lahir_kk"
                                                        class="form-control form-control-sm tanggal-terformat"
                                                        placeholder="Tanggal Lahir"
                                                        value="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_lahir 
                                                            ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_lahir)->translatedFormat('d F Y') 
                                                            : '' }}"
                                                        data-default="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_lahir }}"
                                                        {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Baptis</th>
                                        <td>
                                            <input type="text"
                                                id="ubahdata"
                                                name="tanggal_baptis_kk"
                                                class="form-control form-control-sm tanggal-terformat"
                                                placeholder="Tanggal Baptis"
                                                value="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_baptis 
                                                    ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_baptis)->translatedFormat('d F Y') 
                                                    : '' }}"
                                                data-default="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_baptis }}"
                                                {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Sidi</th>
                                        <td>
                                            <input type="text"
                                                id="ubahdata"
                                                name="tanggal_sidi_kk"
                                                class="form-control form-control-sm tanggal-terformat"
                                                placeholder="Tanggal Sidi"
                                                value="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_sidi 
                                                    ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_sidi)->translatedFormat('d F Y') 
                                                    : '' }}"
                                                data-default="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_sidi }}"
                                                {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>    
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status dan Tanggal Pernikahan</th>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select class="form-control form-control-sm" name="status_menikah_kk" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                        
                                                        <option @if($kepalaKeluarga->jemaatKK->status_menikah == 'Belum Menikah') selected @endif value="Belum Menikah">Belum Menikah </option>
                                                        <option @if($kepalaKeluarga->jemaatKK->status_menikah == 'Menikah') selected @endif value="Menikah">Menikah</option>
                                                        <option @if($kepalaKeluarga->jemaatKK->status_menikah == 'Lainnya') selected @endif value="Lainnya">Lainnya</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text"
                                                    id="ubahdata"
                                                    name="tanggal_nikah_kk"
                                                    class="form-control form-control-sm tanggal-terformat"
                                                    placeholder="Tanggal Sidi"
                                                    value="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_nikah 
                                                        ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_nikah)->translatedFormat('d F Y') 
                                                        : '' }}"
                                                    data-default="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_nikah }}"
                                                    {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Gereja Asal dan Tanggal Terdaftar</th>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" id="ubahdata" name="asal_gereja_kk" value="{{ $kepalaKeluarga->jemaatKK->asal_gereja ?? '-' }}" placeholder="Gereja Asal" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text"
                                                        id="ubahdata"
                                                        name="tanggal_terdaftar_kk"
                                                        class="form-control form-control-sm tanggal-terformat"
                                                        placeholder="Tanggal Sidi"
                                                        value="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_terdaftar 
                                                            ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_terdaftar)->translatedFormat('d F Y') 
                                                            : '' }}"
                                                        data-default="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_terdaftar }}"
                                                        {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Grup Wilayah</th>
                                        <td>
                                            <input type="text" id="ubahdata" name="group_wilayah_kk" value="{{ $kepalaKeluarga->id_group_wilayah ?? '-' }}" placeholder="" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status Keanggotaan<span class="text-danger">*</span></th>
                                        @php
                                            $badgeClass = $kepalaKeluarga->jemaatKK->status_aktif == 'Aktif' ? 'bg-gradient-success' :
                                                        ($kepalaKeluarga->jemaatKK->status_aktif == 'Meninggal Dunia' ? 'bg-gradient-primary' : 'bg-gradient-danger');
                                        @endphp
                                        <td>
                                            <span id="status-keanggotaan-row" class="badge {{ $badgeClass }} text-white" style="font-size:9pt">
                                                @if(in_array($kepalaKeluarga->jemaatKK->status_aktif, ['Pindah Gereja', 'Atestasi Keluar']))
                                                    {{ $kepalaKeluarga->jemaatKK->status_aktif }} ke {{ optional($kepalaKeluarga->jemaatKK->atestasiJemaatKeluar)->gereja ?? '-' }},
                                                    tanggal {{ optional($kepalaKeluarga->jemaatKK->atestasiJemaatKeluar)->tanggal ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->atestasiJemaatKeluar->tanggal)->translatedFormat('d F Y') : '' }}
                                                @else
                                                    {{ $kepalaKeluarga->jemaatKK->status_aktif ?? '-' }}
                                                @endif
                                            </span>
                                            <div class="row" id="status-row" style="display: none;">
                                                <div class="col-md-6">
                                                    <select class="form-control form-control-sm status-aktif-select" required  name="status_aktif_kk" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                        <option @if($kepalaKeluarga->jemaatKK->status_aktif == 'Aktif') selected @endif value="Aktif">Aktif</option>
                                                        <option @if($kepalaKeluarga->jemaatKK->status_aktif == 'Pasif') selected @endif value="Pasif">Pasif</option>
                                                        <option @if($kepalaKeluarga->jemaatKK->status_aktif == 'Atestasi Keluar') selected @endif value="Atestasi Keluar">Atestasi Keluar</option>
                                                        <option @if($kepalaKeluarga->jemaatKK->status_aktif == 'Pindah Gereja') selected @endif value="Pindah Gereja">Pindah Gereja </option>
                                                        <option @if($kepalaKeluarga->jemaatKK->status_aktif == 'Meninggal Dunia') selected @endif value="Meninggal Dunia">Meninggal Dunia</option>
                                                        <option @if($kepalaKeluarga->jemaatKK->status_aktif == 'Bukan Anggota') selected @endif value="Bukan Anggota">Bukan Anggota</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="hidden" id="tanggal_pindah_kk" name="tanggal_pindah_kk">
                                                    <input type="hidden" id="gereja_tujuan_kk" name="gereja_tujuan_kk">
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
                            <a href="#" id="addRow" class="btn btn-primary mb-2 btn-sm">Tambah Anggota Keluarga</a> <a href="#" id="ambil" class="btn btn-warning mb-2 btn-sm">Ambil dari Data Jemaat</a>
                                <div class="modal fade" id="modalJemaat" tabindex="-1" aria-labelledby="modalJemaatLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalJemaatLabel">Pilih Data Jemaat</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" id="searchJemaat" class="form-control mb-2" placeholder="Ketik nama jemaat...">
                                            <ul class="list-group" id="listJemaat"></ul>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            <table class="table table-hover data-table warping" id="tableBody">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">N I A<span class="text-danger">*</span></th>
                                        <th class="text-center">Nama Jemaat<span class="text-danger">*</span></th>
                                        <th class="text-center">L / P<span class="text-danger">*</span></th>
                                        <th class="text-center">Hubungan<span class="text-danger">*</span></th>
                                        <th class="text-center">Tempat<br>Lahir<span class="text-danger">*</span></th>
                                        <th class="text-center">Tanggal<br>Lahir<span class="text-danger">*</span></th>
                                        <th class="text-center">Tanggal<br>Baptis</th>
                                        <th class="text-center">Tanggal<br>Sidi</th>
                                        <th class="text-center">Status<br>Pernikahan</th>
                                        <th class="text-center">Gereja Asal</th>
                                        <th class="text-center">Tanggal<br>Terdaftar</th>
                                        <th class="text-center">Status<br>Keanggotaan<span class="text-danger">*</span></th>
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
                                                <input type="hidden" name="id_anggota[]" value="{{ $anggota->jemaat->id_jemaat }}">
                                            </td>
                                            <td>
                                                @php
                                                    // Cek apakah id_jemaat dari anggota ini ada di dalam kk_jemaat
                                                    $isKK = in_array($anggota->jemaat->id_jemaat, $kk_jemaat->pluck('id_jemaat')->toArray());
                                                @endphp

                                                <div class="d-flex align-items-center gap-1">
                                                <input type="text"
                                                        required
                                                        id="ubahdata"
                                                        style="width:150px;"
                                                        name="nama_jemaat[]"
                                                        value="{{ $anggota->jemaat->nama_jemaat ?? 'Tidak Diketahui' }}"
                                                        placeholder="Nama Jemaat"
                                                        class="form-control form-control-sm"
                                                        {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                    @if ($isKK)
                                                        <a href="{{ route('administrasi.data-jemaat.show', $anggota->jemaat->id_jemaat) }}"
                                                        class="text-primary"
                                                        target="_blank"
                                                        title="Lihat Detail">&nbsp;
                                                            <i class="ni ni-zoom-split-in fs-5" style="font-size:15pt"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <select name="p_l[]" id="ubahdata" style="width: 50px;" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }} required>
                                                    <option value="L" {{ ($anggota->jemaat->gender ?? '') == 'L' ? 'selected' : '' }}>L</option>
                                                    <option value="P" {{ ($anggota->jemaat->gender ?? '') == 'P' ? 'selected' : '' }}>P</option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control form-control-sm" required name="hubungan_keluarga[]" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                    
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
                                                </select>    
                                            </td>
                                            <td class="text-center">
                                                <input type="text" required id="ubahdata" style="width:150px;" name="tempat_lahir[]" value="{{ $anggota->jemaat->tempat_lahir ?? 'Tidak Diketahui' }}" placeholder="Tempat Lahir" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                            </td>
                                            <td class="text-center">
                                                <input required type="text"
                                                        id="ubahdata"
                                                        name="tanggal_lahir[]"
                                                        class="form-control form-control-sm tanggal-terformat"
                                                        placeholder="Tanggal Lahir"
                                                        value="{{ optional($anggota->jemaat)->tanggal_lahir
                                                            ? \Carbon\Carbon::parse($anggota->jemaat->tanggal_lahir)->translatedFormat('d F Y') 
                                                            : '' }}"
                                                        data-default="{{ optional($anggota->jemaat)->tanggal_lahir }}"
                                                        {{ isset($anggotaKeluarga) ? 'disabled' : '' }} style="width:130px;">
                                            </td>
                                            <td class="text-center">
                                                <input type="text"
                                                        id="ubahdata"
                                                        name="tanggal_baptis[]"
                                                        class="form-control form-control-sm tanggal-terformat"
                                                        placeholder="Tanggal Baptis"
                                                        value="{{ optional($anggota->jemaat)->tanggal_baptis
                                                            ? \Carbon\Carbon::parse($anggota->jemaat->tanggal_baptis)->translatedFormat('d F Y') 
                                                            : '' }}"
                                                        data-default="{{ optional($anggota->jemaat)->tanggal_baptis }}"
                                                        {{ isset($anggotaKeluarga) ? 'disabled' : '' }} style="width:130px;">
                                            </td>
                                            <td class="text-center">
                                                <input type="text"
                                                        id="ubahdata"
                                                        name="tanggal_sidi[]"
                                                        class="form-control form-control-sm tanggal-terformat"
                                                        placeholder="Tanggal Sidi"
                                                        value="{{ optional($anggota->jemaat)->tanggal_sidi
                                                            ? \Carbon\Carbon::parse($anggota->jemaat->tanggal_sidi)->translatedFormat('d F Y') 
                                                            : '' }}"
                                                        data-default="{{ optional($anggota->jemaat)->tanggal_sidi }}"
                                                        {{ isset($anggotaKeluarga) ? 'disabled' : '' }} style="width:130px;">
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control form-control-sm" required name="status_menikah[]" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                    <option @if($anggota->jemaat->status_menikah == 'Menikah') selected @endif value="Menikah">Menikah</option>
                                                    <option @if($anggota->jemaat->status_menikah == 'Belum Menikah') selected @endif value="Belum Menikah">Belum Menikah</option>
                                                    <option @if($anggota->jemaat->status_menikah == 'Lainnya') selected @endif value="Lainnya">Lainnya</option>
                                                </select>    
                                            </td>
                                            <td class="text-center">
                                                <input type="text" id="ubahdata" style="width:150px;"  name="asal_gereja[]" value="{{ $anggota->jemaat->asal_gereja ?? 'Tidak Diketahui' }}" placeholder="" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                            <td class="text-center">
                                                <input type="text"
                                                        id="ubahdata"
                                                        name="tanggal_terdaftar[]"
                                                        class="form-control form-control-sm tanggal-terformat"
                                                        placeholder="Tanggal Terdaftar"
                                                        value="{{ optional($anggota->jemaat)->tanggal_terdaftar
                                                            ? \Carbon\Carbon::parse($anggota->jemaat->tanggal_terdaftar)->translatedFormat('d F Y') 
                                                            : '' }}"
                                                        data-default="{{ optional($anggota->jemaat)->tanggal_terdaftar }}"
                                                        {{ isset($anggotaKeluarga) ? 'disabled' : '' }} style="width:130px;">
                                            </td>
                                                @php
                                                $badgeClass = $anggota->jemaat->status_aktif == 'Aktif' ? 'bg-gradient-success' :
                                                        ($anggota->jemaat->status_aktif == 'Meninggal Dunia' ? 'bg-gradient-primary' : 'bg-gradient-danger');
                                                @endphp
                                            <td class="text-center" style="width:200px">
                                                <span id="status-keanggotaan-row1" class="badge {{ $badgeClass }} text-white status-keanggotaan-row1">
                                                    {{ $anggota->jemaat->status_aktif ?? '-' }}
                                                </span>
                                                <div class="row status-row1" id="status-row1" style="display: none;">
                                                    <div class="col-md-12">
                                                        <select class="form-control form-control-sm status-aktif-select" required required name="status_aktif[]" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                            <option @if($anggota->jemaat->status_aktif == 'Aktif') selected @endif value="Aktif">Aktif</option>
                                                            <option @if($anggota->jemaat->status_aktif == 'Pasif') selected @endif value="Pasif">Pasif</option>
                                                            <option @if($anggota->jemaat->status_aktif == 'Atestasi Keluar') selected @endif value="Atestasi Keluar">Atestasi Keluar</option>
                                                            <option @if($anggota->jemaat->status_aktif == 'Pindah Gereja') selected @endif value="Pindah Gereja">Pindah Gereja</option>
                                                            <option @if($anggota->jemaat->status_aktif == 'Meninggal Dunia') selected @endif value="Meninggal Dunia">Meninggal Dunia</option>
                                                            <option @if($anggota->jemaat->status_aktif == 'Bukan Anggota') selected @endif value="Bukan Anggota">Bukan Anggota</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="hidden" name="tanggal_pindah[]" class="tanggal-pindah">
                                                        <input type="hidden" name="gereja_tujuan[]" class="gereja-tujuan">
                                                </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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

    <div class="modal fade" id="popupStatus" tabindex="-1" aria-labelledby="popupLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupLabel">Detail Perpindahan</h5>
            </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="tanggalPerpindahan">Tanggal</label>
                <input type="date" class="form-control" id="tanggalPindah">
            </div>
            <div class="form-group">
                <label for="gerejaTujuan">Gereja Tujuan</label>
                <input type="text" class="form-control" id="gerejaTujuan">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="savePopup">Lanjut</button>
        </div>
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
                    <select class="form-control form-control-sm" style="width:50px;" required name="p_l[]">
                        <option value="L">L</option>
                        <option value="P">P</option>
                    </select>
                </td>
                <td>
                    <select class="form-control form-control-sm" required name="hubungan_keluarga[]">
                        <option value="Kepala Keluarga">Kepala Keluarga</option>
                        <option value="Pasangan">Pasangan</option>
                        <option value="Anak">Anak</option>
                        <option value="Kerabat">Kerabat</option>
                    </select>
                </td>
                <td><input type="text" required class="form-control form-control-sm" name="tempat_lahir[]" placeholder="Tempat Lahir"></td>
                <td><input type="date" required class="form-control form-control-sm tanggal-terformat" name="tanggal_lahir[]"></td>
                <td><input type="date"  class="form-control form-control-sm tanggal-terformat" name="tanggal_baptis[]"></td>
                <td><input type="date"  class="form-control form-control-sm tanggal-terformat" name="tanggal_sidi[]"></td>
                <td>
                    <select class="form-control form-control-sm" required name="status_menikah[]">
                        <option value="Menikah">Menikah</option>
                        <option value="Belum Menikah">Belum Menikah</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </td>
                <td><input type="text" required class="form-control form-control-sm" name="asal_gereja[]" placeholder="Gereja Asal"></td>
                <td><input type="date" class="form-control form-control-sm tanggal-terformat" name="tanggal_terdaftar[]"></td>
                <td>
                    <select class="form-control form-control-sm status-aktif-select" required name="status_aktif[]">
                        <option value="Aktif">Aktif</option>
                        <option value="Atestasi">Pasif</option>
                        <option value="Atestasi Keluar">Atestasi Keluar</option>
                        <option value="Pindah Gereja">Pindah Gereja</option>
                        <option value="Meninggal Dunia">Meninggal Dunia</option>
                        <option value="Bukan Anggota">Bukan Anggota</option>
                    </select>
                     <input type="hidden" name="tanggal_pindah[]" class="tanggal-pindah">
                    <input type="hidden" name="gereja_tujuan[]" class="gereja-tujuan">
                </td>
                <td><input type="text" class="form-control form-control-sm" name="keterangan[]" placeholder="Keterangan" style="width:150px;"></td>
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
            $("#ambil").hide();
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
                $("#ambil").show();
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
                $("#ambil").hide();
                $("#edt").show();
                $("#simpan").hide();
            });
        });
    </script>

    <script>
    // Debounce function
    function debounce(func, delay) {
        let timeout;
        return function () {
        const context = this;
        const args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
        };
    }

    // Tampilkan modal saat tombol diklik
    $('#ambil').on('click', function (e) {
        e.preventDefault();
        $('#modalJemaat').modal('show');
        $('#searchJemaat').val('');
        $('#listJemaat').empty();
    });

    // Fungsi untuk melakukan pencarian ke server
    function cariJemaat() {
        const keyword = $('#searchJemaat').val().trim();

        if (keyword.length < 2) {
        $('#listJemaat').html('<li class="list-group-item">Ketik minimal 2 huruf</li>');
        return;
        }

        $.ajax({
        url: './search-jemaat',
        type: 'GET',
        data: { keyword: keyword },
        success: function (res) {
            $('#listJemaat').empty();

            if (res.length === 0) {
            $('#listJemaat').append('<li class="list-group-item">Tidak ditemukan</li>');
            return;
            }

            res.forEach(function (jemaat) {
            $('#listJemaat').append(`
                <li class="list-group-item list-group-item-action pilih-jemaat" data-id_jemaat="${jemaat.id_jemaat}" data-nama_jemaat="${jemaat.nama_jemaat}">
                ${jemaat.nama_jemaat}
                </li>
            `);
            });
        },
        error: function () {
            $('#listJemaat').html('<li class="list-group-item text-danger">Gagal mengambil data</li>');
        }
        });
    }
    $('#searchJemaat').on('input', debounce(cariJemaat, 400));
    
    $(document).on('click', '.pilih-jemaat', function () {
    const id_jemaat = $(this).data('id_jemaat');
    const nama_jemaat = $(this).data('nama_jemaat');
    const id_kk_jemaat = getIdFromUrl(); // ini dari URL

    if (!id_kk_jemaat) {
        alert('ID administrasi tidak ditemukan di URL.');
        return;
    }

    $.ajax({
        url: '{{ route("administrasi.data-jemaat.simpan") }}',
        type: 'POST',
        data: {
            id_jemaat: id_jemaat,
            id_kk_jemaat: id_kk_jemaat,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            $('#modalJemaat').modal('hide');

            Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Anggota keluarga berhasil ditambahkan.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
            }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
            });
        },
        error: function (xhr) {
            let message = 'Gagal menyimpan data.';

            if (xhr.status === 409) {
            message = 'Data sudah pernah ditambahkan sebelumnya.';
            }

            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
            confirmButtonColor: '#d33'
            });
        }
        });

    });

    function getIdFromUrl() {
    const path = window.location.pathname;
    const segments = path.split('/');
    const lastSegment = segments.pop() || segments.pop();
    return lastSegment;
    }

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selects = document.querySelectorAll('.status-aktif-select');

            selects.forEach(select => {
                select.addEventListener('change', function () {
                    const value = this.value;

                    if (value === 'Atestasi Keluar' || value === 'Pindah Gereja') {
                        document.getElementById('tanggalPindah').value = '';
                        document.getElementById('gerejaTujuan').value = '';
                        window.activeSelect = this;
                        $('#popupStatus').modal('show');
                    }
                });
            });

            document.getElementById('savePopup').addEventListener('click', function () {
                const tanggal = document.getElementById('tanggalPindah').value;
                const gereja = document.getElementById('gerejaTujuan').value;

                const td = window.activeSelect.closest('td');

                // 🟢 Tangani kepala keluarga secara khusus
                if (window.activeSelect.name === 'status_aktif_kk') {
                    document.getElementById('tanggal_pindah_kk').value = tanggal;
                    document.getElementById('gereja_tujuan_kk').value = gereja;
                    $('#popupStatus').modal('hide');
                    return;
                }

                // 🟡 Proses anggota keluarga
                let tanggalInput = td.querySelector('.tanggal-pindah');
                let gerejaInput = td.querySelector('.gereja-tujuan');

                if (!tanggalInput) {
                    tanggalInput = document.createElement('input');
                    tanggalInput.type = 'hidden';
                    tanggalInput.name = 'tanggal_pindah[]';
                    tanggalInput.classList.add('tanggal-pindah');
                    td.appendChild(tanggalInput);
                }

                if (!gerejaInput) {
                    gerejaInput = document.createElement('input');
                    gerejaInput.type = 'hidden';
                    gerejaInput.name = 'gereja_tujuan[]';
                    gerejaInput.classList.add('gereja-tujuan');
                    td.appendChild(gerejaInput);
                }

                tanggalInput.value = tanggal;
                gerejaInput.value = gereja;

                $('#popupStatus').modal('hide');
            });
        });
    </script>

    @endsection

    
