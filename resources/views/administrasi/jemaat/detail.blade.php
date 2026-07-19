
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

    <div class="container-fluid mt-6">
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap py-3">
                <h4 class="mb-0 font-weight-bold">Detail Data Jemaat</h4>
                @if(isset($anggotaKeluarga))
                <div class="d-flex align-items-center gap-2 mt-2 mt-md-0 flex-wrap">
                    <a class="btn btn-secondary btn-sm batal" id="btl" style="display:none;">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <a class="btn btn-primary btn-sm edit" id="edt">
                        <i class="fas fa-pencil-alt"></i> Ubah Data
                    </a>
                    <a href="{{ route('administrasi.data-jemaat.cetak', $id) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                    <form id="delete-form" action="{{ route('administrasi.data-kk.destroy', $id_kk) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete()">
                            <i class="far fa-trash-alt"></i> Hapus
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <div id="alert" class="px-4">
                @include('includes.alert')
            </div>

            <div class="card-body px-4 pt-0 pb-3">
                <form role="form" method="POST" action="{{ $aksi }}" enctype="multipart/form-data" onsubmit="console.log('Form submitting', Array.from(new FormData(this).entries())); const form = this; console.log('Form inputs:', Array.from(form.querySelectorAll('input, select')).map(i => ({name: i.name, value: i.value, disabled: i.disabled})));">
                    @csrf
                    @if(isset($anggotaKeluarga))
                        @method('PUT')
                    @endif
                    <input type="hidden" name="id_kk" value="{{ $id_kk }}">

                    <!-- Data Kepala Keluarga -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-2">
                            <strong><i class="fas fa-home mr-1"></i> Data Kepala Keluarga</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">Nomor Induk Anggota <span class="text-danger">*</span></label>
                                        <input type="text" required name="nia_kk" value="{{ $kepalaKeluarga->jemaatKK->nia ?? '' }}" placeholder="NIA" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">Nama Kepala Keluarga <span class="text-danger">*</span></label>
                                        <input type="text" required name="kepala_keluarga" value="{{ $kepalaKeluarga->jemaatKK->nama_jemaat ?? '' }}" placeholder="Nama Kepala Keluarga" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">L / P <span class="text-danger">*</span></label>
                                        <select name="p_l_kk" class="form-control form-control-sm" required {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                            <option value="L" {{ ($kepalaKeluarga->jemaatKK->gender ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ ($kepalaKeluarga->jemaatKK->gender ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" required name="tempat_lahir_kk" value="{{ $kepalaKeluarga->jemaatKK->tempat_lahir ?? '' }}" placeholder="Tempat Lahir" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="text" required name="tanggal_lahir_kk" class="form-control form-control-sm tanggal-terformat" placeholder="Tanggal Lahir"
                                            value="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_lahir ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_lahir)->translatedFormat('d F Y') : '' }}"
                                            data-default="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_lahir }}"
                                            {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">Alamat <span class="text-danger">*</span></label>
                                        <input type="text" required name="alamat_kk" value="{{ $kepalaKeluarga->alamat ?? '' }}" placeholder="Alamat" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">Wilayah</label>
                                        <input type="text" name="group_wilayah_kk" value="{{ $kepalaKeluarga->id_group_wilayah ?? '' }}" placeholder="Wilayah" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">No. Telepon / HP <span class="text-danger">*</span></label>
                                        <input type="text" required name="telepon_kk" value="{{ $kepalaKeluarga->jemaatKK->telepon ?? '' }}" placeholder="No. HP" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">Tanggal Baptis</label>
                                        <input type="text" name="tanggal_baptis_kk" class="form-control form-control-sm tanggal-terformat" placeholder="Tanggal Baptis"
                                            value="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_baptis ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_baptis)->translatedFormat('d F Y') : '' }}"
                                            data-default="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_baptis }}"
                                            {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">Tanggal Sidi</label>
                                        <input type="text" name="tanggal_sidi_kk" class="form-control form-control-sm tanggal-terformat" placeholder="Tanggal Sidi"
                                            value="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_sidi ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_sidi)->translatedFormat('d F Y') : '' }}"
                                            data-default="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_sidi }}"
                                            {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">Status Pernikahan</label>
                                        <select class="form-control form-control-sm" name="status_menikah_kk" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                            <option value="Belum Menikah" {{ ($kepalaKeluarga->jemaatKK->status_menikah ?? '') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                            <option value="Menikah" {{ ($kepalaKeluarga->jemaatKK->status_menikah ?? '') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                            <option value="Lainnya" {{ ($kepalaKeluarga->jemaatKK->status_menikah ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">Tanggal Nikah</label>
                                        <input type="text" name="tanggal_nikah_kk" class="form-control form-control-sm tanggal-terformat" placeholder="Tanggal Nikah"
                                            value="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_nikah ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_nikah)->translatedFormat('d F Y') : '' }}"
                                            data-default="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_nikah }}"
                                            {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">Gereja Asal</label>
                                        <input type="text" name="asal_gereja_kk" value="{{ $kepalaKeluarga->jemaatKK->asal_gereja ?? '' }}" placeholder="Gereja Asal" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">Tanggal Terdaftar</label>
                                        <input type="text" name="tanggal_terdaftar_kk" class="form-control form-control-sm tanggal-terformat" placeholder="Tanggal Terdaftar"
                                            value="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_terdaftar ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_terdaftar)->translatedFormat('d F Y') : '' }}"
                                            data-default="{{ optional($kepalaKeluarga->jemaatKK)->tanggal_terdaftar }}"
                                            {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">Status Keanggotaan <span class="text-danger">*</span></label>
                                        @php
                                            $badgeClass = ($kepalaKeluarga->jemaatKK->status_aktif ?? '') == 'Aktif' ? 'bg-gradient-success' :
                                                        (($kepalaKeluarga->jemaatKK->status_aktif ?? '') == 'Meninggal Dunia' ? 'bg-gradient-primary' : 'bg-gradient-danger');
                                        @endphp
                                        <div>
                                            <span id="status-keanggotaan-row" class="badge {{ $badgeClass }} text-white" style="font-size: 0.65rem; padding: 0.3rem 0.5rem; cursor: pointer;">
                                                {{ $kepalaKeluarga->jemaatKK->status_aktif ?? '-' }}
                                            </span>
                                        </div>
                                        <div class="mt-2" id="status-row" style="display: none;">
                                            <select class="form-control form-control-sm status-aktif-select" required name="status_aktif_kk" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                <option value="Aktif" {{ ($kepalaKeluarga->jemaatKK->status_aktif ?? '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="Pasif" {{ ($kepalaKeluarga->jemaatKK->status_aktif ?? '') == 'Pasif' ? 'selected' : '' }}>Pasif</option>
                                                <option value="Atestasi Keluar" {{ ($kepalaKeluarga->jemaatKK->status_aktif ?? '') == 'Atestasi Keluar' ? 'selected' : '' }}>Atestasi Keluar</option>
                                                <option value="Pindah Gereja" {{ ($kepalaKeluarga->jemaatKK->status_aktif ?? '') == 'Pindah Gereja' ? 'selected' : '' }}>Pindah Gereja</option>
                                                <option value="Meninggal Dunia" {{ ($kepalaKeluarga->jemaatKK->status_aktif ?? '') == 'Meninggal Dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
                                                <option value="Bukan Anggota" {{ ($kepalaKeluarga->jemaatKK->status_aktif ?? '') == 'Bukan Anggota' ? 'selected' : '' }}>Bukan Anggota</option>
                                                <option value="Tidak Aktif" {{ ($kepalaKeluarga->jemaatKK->status_aktif ?? '') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                            </select>
                                            <input type="hidden" id="tanggal_pindah_kk" name="tanggal_pindah_kk">
                                            <input type="hidden" id="gereja_tujuan_kk" name="gereja_tujuan_kk">
                                            <input type="hidden" id="tanggal_meninggal_kk" name="tanggal_meninggal_kk">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold small">Keterangan</label>
                                        <input type="text" name="keterangan_kk" value="{{ $kepalaKeluarga->jemaatKK->keterangan ?? '' }}" placeholder="Keterangan" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Anggota Keluarga -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white py-2 d-flex align-items-center justify-content-between">
                            <strong><i class="fas fa-users mr-1"></i> Detail Anggota Keluarga</strong>
                            <span class="badge badge-light text-dark">{{ $anggotaKeluarga->count() }} orang</span>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <a href="#" id="addRow" class="btn btn-primary btn-sm mr-2" style="display:none;">
                                    <i class="fas fa-plus"></i> Tambah Anggota
                                </a>
                                <a href="#" id="ambil" class="btn btn-warning btn-sm" style="display:none;">
                                    <i class="fas fa-search"></i> Ambil dari Data Jemaat
                                </a>
                            </div>

                            <!-- Modal Pilih Jemaat -->
                            <div class="modal fade" id="modalJemaat" tabindex="-1" aria-labelledby="modalJemaatLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header py-2">
                                            <h6 class="modal-title" id="modalJemaatLabel">Pilih Data Jemaat</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" id="searchJemaat" class="form-control form-control-sm mb-2" placeholder="Ketik nama jemaat...">
                                            <ul class="list-group" id="listJemaat" style="max-height: 300px; overflow-y: auto;"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-sm align-middle mb-0" id="tableBody" style="min-width: 1400px;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center" style="width:35px;">#</th>
                                            <th class="text-center" style="min-width:80px;">NIA</th>
                                            <th class="text-center" style="min-width:160px;">Nama Jemaat</th>
                                            <th class="text-center" style="width:55px;">L/P</th>
                                            <th class="text-center" style="width:100px;">Hubungan</th>
                                            <th class="text-center" style="min-width:110px;">No. HP</th>
                                            <th class="text-center" style="min-width:130px;">Tempat Lahir</th>
                                            <th class="text-center" style="min-width:120px;">Tgl Lahir</th>
                                            <th class="text-center" style="min-width:120px;">Tgl Baptis</th>
                                            <th class="text-center" style="min-width:120px;">Tgl Sidi</th>
                                            <th class="text-center" style="width:110px;">Status Nikah</th>
                                            <th class="text-center" style="min-width:130px;">Gereja Asal</th>
                                            <th class="text-center" style="min-width:120px;">Tgl Terdaftar</th>
                                            <th class="text-center" style="min-width:130px;">Status</th>
                                            <th class="text-center" style="min-width:120px;">Keterangan</th>
                                            <th class="text-center" style="width:40px;"></th>
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
                                                    <input type="text" required style="width:80px;" name="nia_anggota[]" value="{{ $anggota->jemaat->nia ?? '' }}" placeholder="NIA" class="form-control form-control-sm nia" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                    <input type="hidden" name="id_anggota[]" value="{{ $anggota->jemaat->id_jemaat }}">
                                                </td>
                                                <td>
                                                    @php
                                                        $isKK = in_array($anggota->jemaat->id_jemaat, $kk_jemaat->pluck('id_jemaat')->toArray());
                                                        $isPasangan = strtolower(optional($anggota)->hubungan_keluarga) === 'pasangan';
                                                        $isEligibleToCreateKK = (
                                                            $anggota->jemaat->status_menikah === 'Menikah' &&
                                                            $anggota->jemaat->gender === 'P' &&
                                                            !$isPasangan &&
                                                            !$isKK
                                                        );
                                                    @endphp
                                                    <div class="d-flex align-items-center gap-1">
                                                        <input type="text" required style="min-width:140px;" name="nama_jemaat[]" value="{{ $anggota->jemaat->nama_jemaat ?? '' }}" placeholder="Nama Jemaat" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                        @if ($isKK)
                                                            <a href="{{ route('administrasi.data-jemaat.show', $anggota->jemaat->id_jemaat) }}" class="text-primary" target="_blank" title="Lihat Detail">
                                                                <i class="fas fa-external-link-alt fa-sm"></i>
                                                            </a>
                                                        @endif
                                                        @if ($isEligibleToCreateKK)
                                                            <button type="button" class="btn btn-sm btn-success" title="Jadikan Kepala Keluarga" onclick="buatKK('{{ $anggota->jemaat->id_jemaat }}')">
                                                                <i class="fas fa-plus fa-sm"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="p_l[]" style="width:55px;" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }} required>
                                                        <option value="L" {{ ($anggota->jemaat->gender ?? '') == 'L' ? 'selected' : '' }}>L</option>
                                                        <option value="P" {{ ($anggota->jemaat->gender ?? '') == 'P' ? 'selected' : '' }}>P</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control form-control-sm" required name="hubungan_keluarga[]" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                        <option value="Pasangan" {{ (optional($anggota)->hubungan_keluarga == 'Pasangan') ? 'selected' : '' }}>Pasangan</option>
                                                        <option value="Anak" {{ (optional($anggota)->hubungan_keluarga == 'Anak') ? 'selected' : '' }}>Anak</option>
                                                        <option value="Kerabat" {{ (optional($anggota)->hubungan_keluarga == 'Kerabat') ? 'selected' : '' }}>Kerabat</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="telepon[]" value="{{ $anggota->jemaat->telepon ?? '' }}" placeholder="No. HP" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                </td>
                                                <td>
                                                    <input type="text" required name="tempat_lahir[]" value="{{ $anggota->jemaat->tempat_lahir ?? '' }}" placeholder="Tempat Lahir" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                </td>
                                                <td>
                                                    <input type="text" name="tanggal_lahir[]" class="form-control form-control-sm tanggal-terformat" placeholder="Tgl Lahir"
                                                        value="{{ optional($anggota->jemaat)->tanggal_lahir ? \Carbon\Carbon::parse($anggota->jemaat->tanggal_lahir)->translatedFormat('d F Y') : '' }}"
                                                        data-default="{{ optional($anggota->jemaat)->tanggal_lahir }}"
                                                        {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                </td>
                                                <td>
                                                    <input type="text" name="tanggal_baptis[]" class="form-control form-control-sm tanggal-terformat" placeholder="Tgl Baptis"
                                                        value="{{ optional($anggota->jemaat)->tanggal_baptis ? \Carbon\Carbon::parse($anggota->jemaat->tanggal_baptis)->translatedFormat('d F Y') : '' }}"
                                                        data-default="{{ optional($anggota->jemaat)->tanggal_baptis }}"
                                                        {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                </td>
                                                <td>
                                                    <input type="text" name="tanggal_sidi[]" class="form-control form-control-sm tanggal-terformat" placeholder="Tgl Sidi"
                                                        value="{{ optional($anggota->jemaat)->tanggal_sidi ? \Carbon\Carbon::parse($anggota->jemaat->tanggal_sidi)->translatedFormat('d F Y') : '' }}"
                                                        data-default="{{ optional($anggota->jemaat)->tanggal_sidi }}"
                                                        {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                </td>
                                                <td>
                                                    <select class="form-control form-control-sm" required name="status_menikah[]" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                        <option value="Menikah" {{ ($anggota->jemaat->status_menikah ?? '') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                                        <option value="Belum Menikah" {{ ($anggota->jemaat->status_menikah ?? '') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                                        <option value="Lainnya" {{ ($anggota->jemaat->status_menikah ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="asal_gereja[]" value="{{ $anggota->jemaat->asal_gereja ?? '' }}" placeholder="Gereja Asal" class="form-control form-control-sm" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                </td>
                                                <td>
                                                    <input type="text" name="tanggal_terdaftar[]" class="form-control form-control-sm tanggal-terformat" placeholder="Tgl Terdaftar"
                                                        value="{{ optional($anggota->jemaat)->tanggal_terdaftar ? \Carbon\Carbon::parse($anggota->jemaat->tanggal_terdaftar)->translatedFormat('d F Y') : '' }}"
                                                        data-default="{{ optional($anggota->jemaat)->tanggal_terdaftar }}"
                                                        {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $badgeClass }} text-white status-keanggotaan-row1 py-1 px-2" style="font-size: 0.6rem; white-space: nowrap;">
                                                        {{ $anggota->jemaat->status_aktif ?? '-' }}
                                                    </span>
                                                    <div class="status-row1" style="display: none;">
                                                        <select class="form-control form-control-sm status-aktif-select" required name="status_aktif[]" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                            <option value="Aktif" {{ ($anggota->jemaat->status_aktif ?? '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                            <option value="Pasif" {{ ($anggota->jemaat->status_aktif ?? '') == 'Pasif' ? 'selected' : '' }}>Pasif</option>
                                                            <option value="Atestasi Keluar" {{ ($anggota->jemaat->status_aktif ?? '') == 'Atestasi Keluar' ? 'selected' : '' }}>Atestasi Keluar</option>
                                                            <option value="Pindah Gereja" {{ ($anggota->jemaat->status_aktif ?? '') == 'Pindah Gereja' ? 'selected' : '' }}>Pindah Gereja</option>
                                                            <option value="Meninggal Dunia" {{ ($anggota->jemaat->status_aktif ?? '') == 'Meninggal Dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
                                                            <option value="Bukan Anggota" {{ ($anggota->jemaat->status_aktif ?? '') == 'Bukan Anggota' ? 'selected' : '' }}>Bukan Anggota</option>
                                                            <option value="Tidak Aktif" {{ ($anggota->jemaat->status_aktif ?? '') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                        </select>
                                                        <input type="hidden" name="tanggal_pindah[]" class="tanggal-pindah">
                                                        <input type="hidden" name="gereja_tujuan[]" class="gereja-tujuan">
                                                        <input type="hidden" name="tanggal_meninggal[]" class="tanggal-meninggal">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm" name="keterangan[]" placeholder="Keterangan" style="min-width:120px;" value="{{ $anggota->jemaat->keterangan ?? '' }}" {{ isset($anggotaKeluarga) ? 'disabled' : '' }}>
                                                </td>
                                                <td>
                                                    <a class="btn btn-link text-danger p-0 removeRow" data-confirm-delete="true" href="{{ route('administrasi.data-jemaat.destroy', $anggota->jemaat->id_jemaat) }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light py-3 d-flex align-items-center justify-content-between flex-wrap">
                            <button type="submit" id="simpan" class="btn btn-warning bg-gradient-warning btn-sm" style="display:none;">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <small class="text-danger"><i class="fas fa-exclamation-circle"></i> Tanda <span class="text-danger">*</span> harus diisi dengan lengkap.</small>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <!-- Modal Status Perpindahan -->
    <div class="modal fade" id="popupStatus" tabindex="-1" aria-labelledby="popupLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h6 class="modal-title" id="popupLabel">Detail Perpindahan</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold small">Tanggal Pindah</label>
                        <input type="date" class="form-control form-control-sm" id="tanggalPindah">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label fw-bold small">Gereja Tujuan</label>
                        <input type="text" class="form-control form-control-sm" id="gerejaTujuan" placeholder="Nama gereja tujuan">
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-sm" id="savePopup">Lanjut</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Meninggal Dunia -->
    <div class="modal fade" id="popupMeninggal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h6 class="modal-title">Tanggal Meninggal Dunia</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label class="form-label fw-bold small">Tanggal Meninggal</label>
                        <input type="date" id="tanggalMeninggal" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-sm" id="saveTanggalMeninggal">Lanjut</button>
                </div>
            </div>
        </div>
    </div>

        @include('layouts.footers.auth.footer')
    </div>

    <style>
        .form-label { margin-bottom: 0.3rem; color: #555; }
        .table td { vertical-align: middle; padding: 0.4rem 0.3rem; }
        .table th { vertical-align: middle; padding: 0.4rem 0.3rem; font-size: 0.78rem; white-space: nowrap; }
        #tableBody .form-control-sm, #tableBody .form-control-sm:not(.tanggal-terformat) { font-size: 0.8rem; }
        .badge { cursor: default; }
    </style>

    <script>
        $(document).ready(function () {
            $("#addRow").click(function (e) {
                e.preventDefault();
                var newRow = `<tr>
                    <td class="text-center"></td>
                    <td><input type="text" required style="width:80px;" name="nia_anggota[]" placeholder="NIA" class="form-control form-control-sm nia"></td>
                    <td><input type="text" required style="min-width:140px;" class="form-control form-control-sm" name="nama_jemaat[]" placeholder="Nama Jemaat"></td>
                    <td>
                        <select class="form-control form-control-sm" style="width:55px;" required name="p_l[]">
                            <option value="L">L</option>
                            <option value="P">P</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control form-control-sm" required name="hubungan_keluarga[]">
                            <option value="Pasangan">Pasangan</option>
                            <option value="Anak">Anak</option>
                            <option value="Kerabat">Kerabat</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control form-control-sm" name="telepon[]" placeholder="No. HP"></td>
                    <td><input type="text" required class="form-control form-control-sm" name="tempat_lahir[]" placeholder="Tempat Lahir"></td>
                    <td><input type="text" class="form-control form-control-sm tanggal-terformat" name="tanggal_lahir[]" placeholder="Tgl Lahir"></td>
                    <td><input type="text" class="form-control form-control-sm tanggal-terformat" name="tanggal_baptis[]" placeholder="Tgl Baptis"></td>
                    <td><input type="text" class="form-control form-control-sm tanggal-terformat" name="tanggal_sidi[]" placeholder="Tgl Sidi"></td>
                    <td>
                        <select class="form-control form-control-sm" required name="status_menikah[]">
                            <option value="Menikah">Menikah</option>
                            <option value="Belum Menikah">Belum Menikah</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control form-control-sm" name="asal_gereja[]" placeholder="Gereja Asal"></td>
                    <td><input type="text" class="form-control form-control-sm tanggal-terformat" name="tanggal_terdaftar[]" placeholder="Tgl Terdaftar"></td>
                    <td>
                        <select class="form-control form-control-sm status-aktif-select" required name="status_aktif[]">
                            <option value="Aktif">Aktif</option>
                            <option value="Pasif">Pasif</option>
                            <option value="Atestasi Keluar">Atestasi Keluar</option>
                            <option value="Pindah Gereja">Pindah Gereja</option>
                            <option value="Meninggal Dunia">Meninggal Dunia</option>
                            <option value="Bukan Anggota">Bukan Anggota</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                        <input type="hidden" name="tanggal_pindah[]" class="tanggal-pindah">
                        <input type="hidden" name="gereja_tujuan[]" class="gereja-tujuan">
                    </td>
                    <td><input type="text" class="form-control form-control-sm" name="keterangan[]" placeholder="Keterangan" style="min-width:120px;"></td>
                    <td><button class="btn btn-link text-danger p-0 removeRow"><i class="fas fa-trash-alt"></i></button></td>
                </tr>`;

                $("#tableBody tbody").append(newRow);
                updateRowNumbers();
            });

            $(document).on("click", ".removeRow", function (e) {
                e.preventDefault();
                $(this).closest("tr").remove();
                updateRowNumbers();
            });

            function updateRowNumbers() {
                $("#tableBody tbody tr").each(function (index) {
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
        function debounce(func, delay) {
            let timeout;
            return function () {
                const context = this;
                const args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        $('#ambil').on('click', function (e) {
            e.preventDefault();
            $('#modalJemaat').modal('show');
            $('#searchJemaat').val('');
            $('#listJemaat').empty();
        });

        function cariJemaat() {
            const keyword = $('#searchJemaat').val().trim();
            if (keyword.length < 2) {
                $('#listJemaat').html('<li class="list-group-item text-muted">Ketik minimal 2 huruf</li>');
                return;
            }
            $.ajax({
                url: './search-jemaat',
                type: 'GET',
                data: { keyword: keyword },
                success: function (res) {
                    $('#listJemaat').empty();
                    if (res.length === 0) {
                        $('#listJemaat').append('<li class="list-group-item text-muted">Tidak ditemukan</li>');
                        return;
                    }
                    res.forEach(function (jemaat) {
                        $('#listJemaat').append(`
                            <li class="list-group-item list-group-item-action pilih-jemaat" data-id_jemaat="${jemaat.id_jemaat}" data-nama_jemaat="${jemaat.nama_jemaat}" style="cursor:pointer;">
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
            const id_kk_jemaat = getIdFromUrl();

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
                        if (result.isConfirmed) { location.reload(); }
                    });
                },
                error: function (xhr) {
                    let message = 'Gagal menyimpan data.';
                    if (xhr.status === 409) { message = 'Data sudah pernah ditambahkan sebelumnya.'; }
                    Swal.fire({ icon: 'error', title: 'Oops...', text: message, confirmButtonColor: '#d33' });
                }
            });
        });

        function getIdFromUrl() {
            const path = window.location.pathname;
            const segments = path.split('/');
            return segments.pop() || segments.pop();
        }
    </script>

    <script>
document.addEventListener('DOMContentLoaded', function () {
            console.log('DOMContentLoaded - attaching event listeners');
            
            const selects = document.querySelectorAll('.status-aktif-select');
            console.log('Found status-aktif-select elements:', selects.length);
            
            selects.forEach(select => {
                select.addEventListener('change', function () {
                    const value = this.value;
                    console.log('Status changed to:', value);
                    if (value === 'Atestasi Keluar' || value === 'Pindah Gereja') {
                        document.getElementById('tanggalPindah').value = '';
                        document.getElementById('gerejaTujuan').value = '';
                        window.activeSelect = this;
                        $('#popupStatus').modal('show');
                    } else if (value === 'Meninggal Dunia') {
                        document.getElementById('tanggalMeninggal').value = '';
                        window.activeSelect = this;
                        $('#popupMeninggal').modal('show');
                    }
                });
            });

            console.log('savePopup element:', document.getElementById('savePopup'));
            document.getElementById('savePopup').addEventListener('click', function () {
                console.log('savePopup CLICKED!');
                const tanggal = document.getElementById('tanggalPindah').value;
                const gereja = document.getElementById('gerejaTujuan').value;
                const td = window.activeSelect?.closest('td');

                console.log('savePopup clicked', { 
                    tanggal, 
                    gereja, 
                    activeSelect: window.activeSelect,
                    activeSelectName: window.activeSelect?.name,
                    td: td
                });

                if (window.activeSelect?.name === 'status_aktif_kk') {
                    document.getElementById('tanggal_pindah_kk').value = tanggal;
                    document.getElementById('gereja_tujuan_kk').value = gereja;
                    console.log('Set KK hidden inputs', tanggal, gereja);
                    $('#popupStatus').modal('hide');
                    return;
                }

                // For anggota: find the hidden inputs in the same row
                let tanggalInput, gerejaInput;
                
                if (td) {
                    // Try status-row1 div first
                    const statusRow = td.querySelector('.status-row1');
                    console.log('statusRow found:', statusRow);
                    if (statusRow) {
                        tanggalInput = statusRow.querySelector('.tanggal-pindah');
                        gerejaInput = statusRow.querySelector('.gereja-tujuan');
                    }
                }
                
                // Fallback: find by index matching the select
                if (!tanggalInput || !gerejaInput) {
                    const selects = document.querySelectorAll('select[name="status_aktif[]"]');
                    const index = Array.from(selects).indexOf(window.activeSelect);
                    console.log('Active select index:', index);
                    if (index >= 0) {
                        const allTanggalInputs = document.querySelectorAll('input[name="tanggal_pindah[]"]');
                        const allGerejaInputs = document.querySelectorAll('input[name="gereja_tujuan[]"]');
                        if (allTanggalInputs[index]) tanggalInput = allTanggalInputs[index];
                        if (allGerejaInputs[index]) gerejaInput = allGerejaInputs[index];
                    }
                }
                
                // Strategy 3: Find by closest row (tr) then query within that row
                if (!tanggalInput || !gerejaInput) {
                    const tr = window.activeSelect?.closest('tr');
                    console.log('TR found:', tr);
                    if (tr) {
                        tanggalInput = tr.querySelector('input[name="tanggal_pindah[]"]');
                        gerejaInput = tr.querySelector('input[name="gereja_tujuan[]"]');
                        console.log('Found by TR:', { tanggalInput, gerejaInput });
                    }
                }

                console.log('Found inputs:', { tanggalInput, gerejaInput });

                if (tanggalInput) {
                    tanggalInput.value = tanggal;
                    console.log('Set tanggal_pindah[] value to:', tanggalInput.value);
                }
                if (gerejaInput) {
                    gerejaInput.value = gereja;
                    console.log('Set gereja_tujuan[] value to:', gerejaInput.value);
                }
                $('#popupStatus').modal('hide');
            });

            document.getElementById('saveTanggalMeninggal').addEventListener('click', function () {
                const tanggal = document.getElementById('tanggalMeninggal').value;
                const td = window.activeSelect?.closest('td');

                if (window.activeSelect?.name === 'status_aktif_kk') {
                    document.getElementById('tanggal_meninggal_kk').value = tanggal;
                    $('#popupMeninggal').modal('hide');
                    return;
                }

                // For anggota: find hidden input with multiple strategies
                let tanggalMeninggalInput = null;
                
                if (td) {
                    const statusRow = td.querySelector('.status-row1');
                    if (statusRow) {
                        tanggalMeninggalInput = statusRow.querySelector('.tanggal-meninggal');
                    }
                }
                
                // Fallback: find by index
                if (!tanggalMeninggalInput) {
                    const selects = document.querySelectorAll('select[name="status_aktif[]"]');
                    const index = Array.from(selects).indexOf(window.activeSelect);
                    if (index >= 0) {
                        const allInputs = document.querySelectorAll('input[name="tanggal_meninggal[]"]');
                        if (allInputs[index]) tanggalMeninggalInput = allInputs[index];
                    }
                }
                
                // Strategy 3: Find by closest TR
                if (!tanggalMeninggalInput) {
                    const tr = window.activeSelect?.closest('tr');
                    if (tr) {
                        tanggalMeninggalInput = tr.querySelector('input[name="tanggal_meninggal[]"]');
                    }
                }
                
                if (tanggalMeninggalInput) {
                    tanggalMeninggalInput.value = tanggal;
                    console.log('Set tanggal_meninggal[] value to:', tanggalMeninggalInput.value);
                }
                $('#popupMeninggal').modal('hide');
            });
        });
    </script>

    <script>
        function confirmDelete() {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form').submit();
                }
            });
        }

        function buatKK(idJemaat) {
            Swal.fire({
                title: 'Jadikan Kepala Keluarga?',
                text: 'Data ini akan dibuat sebagai Kepala Keluarga baru.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, buat KK',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const url = "{{ route('administrasi.data-kk.createFromJemaat', ['id' => ':id']) }}".replace(':id', idJemaat);
                    window.location.href = url;
                }
            });
        }
    </script>
    @endsection
