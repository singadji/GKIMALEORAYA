    @extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

    @section('content')

    @include('layouts.navbars.auth.topnav')

    @section('alert-error')
        @if (Session::has('errors'))
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
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
                <h3>{{$subjudul}}</h3>
            </div>
            <div class="">
                <div id="alert">
                    @if ($errors->any())
                        <div class="alert alert-danger" style="color:#fff; font-size:10pt">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="">
                    <div id="alert">
                        @include('includes.alert')
                    </div>
                </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="card-body">
                    <form role="form" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @if(isset($item))
                        @method('PUT')
                    @endif
                    <div class="mb-3">
                        <h3>Data Anggota Jemaat</h3>
                        <hr>
                    </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Nomor Induk Anggota</label>
                                    <input class="form-control" type="text" name="nia" placeholder="" 
                                    @if(isset($item)) disabled value="{{ $item->nia }}" 
                                    @else value="{{ old('nia') }}" @endif required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Nama Lengkap</label>
                                    <input class="form-control" type="text" name="nama_jemaat" placeholder="" 
                                    @if(isset($item)) disabled value="{{ $item->nama_jemaat }}" 
                                    @else value="{{ old('nama_jemaat') }}" @endif required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Gender</label>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio"  @if(isset($item) && $item->gender == "L") checked required @endif name="gender" id="">
                                        <label class="" for="">Laki-laki</label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" @if(isset($item) && $item->gender == "P") checked required @endif name="gender" id="">
                                        <label class="" for="">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Alamat Tempat Tinggal</label>
                                    <input class="form-control" type="text" name="alamat" placeholder="" 
                                    @if(isset($item)) value="{{ optional($item->kkJemaat)->alamat ?? optional(optional($item->hubunganKeluarga)->kkJemaat)->alamat ?? '-' }} " 
                                    @else value="{{ old('alamat') }}" @endif required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Nomor Telepon / HP</label>
                                    <input class="form-control" type="text" name="telepon" placeholder="" 
                                    @if(isset($item)) value="{{ $item->telepon }}" 
                                    @else value="{{ old('telepon') }}" @endif required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Tempat Lahir</label>
                                    <input class="form-control" type="text" name="tempat_lahir" placeholder="" 
                                    @if(isset($item)) value="{{ $item->tempat_lahir }}" 
                                    @else value="{{ old('tempat_lahir') }}" @endif required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Tanggal Lahir</label>
                                    <input class="form-control" type="date" name="tanggal_lahir" placeholder="" 
                                    @if(isset($item)) value="{{ $item->tanggal_lahir }}" 
                                    @else value="{{ old('tanggal_lahir') }}" @endif required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Tanggal Baptis</label>
                                    <input class="form-control" type="date" name="tanggal_baptis" placeholder="" 
                                    @if(isset($item)) value="{{ $item->tanggal_baptis }}" 
                                    @else value="{{ old('tanggal_baptis') }}" @endif required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Tanggal Sidi</label>
                                    <input class="form-control" type="date" name="tanggal_sidi" placeholder="" 
                                    @if(isset($item)) value="{{ $item->tanggal_sidi }}" 
                                    @else value="{{ old('tanggal_baptis') }}" @endif required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Gereja Asal</label>
                                    <input class="form-control" type="text" name="asal_gereja" placeholder="" 
                                    @if(isset($item)) value="{{ $item->asal_gereja }}" 
                                    @else value="{{ old('asal_gereja') }}" @endif required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Status Pernikahan</label>
                                    <select class="form-control select2-hidden-accessible" required data-toggle="select" name="status_menikah" @if(isset($item)) @endif>
                                        <option>--pilih--</option>
                                        <option @if(isset($item) && $item->status_menikah == 'Belum Menikah') selected @endif value="Belum Menikah">Belum Menikah </option>
                                        <option @if(isset($item) && $item->status_menikah == 'Menikah') selected @endif value="Menikah">Menikah</option>
                                        <option @if(isset($item) && $item->status_menikah == 'Duda') selected @endif value="Duda">Duda</option>
                                        <option @if(isset($item) && $item->status_menikah == 'Janda') selected @endif value="Janda">Janda</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Tanggal Nikah</label>
                                    <input class="form-control" type="date" name="tanggal_nikah" placeholder="" 
                                    @if(isset($item)) value="{{ $item->tanggal_nikah }}" 
                                    @else value="{{ old('tanggal_nikah') }}" @endif required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-control-label">Status Keanggotaan</label>
                                    <select class="form-control select2-hidden-accessible" required data-toggle="select" name="status_aktif" @if(isset($item)) @endif>
                                        <option>--pilih--</option>
                                        <option @if(isset($item) && $item->status_aktif == 'Aktif') selected @endif value="Aktif">Aktif</option>
                                        <option @if(isset($item) && $item->status_aktif == 'Atestasi') selected @endif value="Atestasi">Atestasi</option>
                                        <option @if(isset($item) && $item->status_aktif == 'Meninggal Dunia') selected @endif value="Meninggal Dunia">Meninggal Dunia</option>
                                        <option @if(isset($item) && $item->status_aktif == 'Tidak Tahu') selected @endif value="Tidak Tahu">Tidak Tahu</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                        `<hr>
                            <h3>Data Keluarga</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Kepala Keluarga</label>
                                    @if(isset($item) && optional($item->kkJemaat)->id_jemaat == $item->id_jemaat)
                                        <!-- Jika item adalah kepala keluarga, tampilkan sebagai teks biasa -->
                                        <input type="text" class="form-control" value="{{ $item->nama_jemaat }}" readonly>
                                        <input type="hidden" name="kk" value="{{ $item->id_jemaat }}">
                                    @else
                                        <!-- Jika bukan kepala keluarga, tampilkan dropdown -->
                                        <select class="form-control select2 select2-hidden-accessible" required data-toggle="select" name="kk">
                                            <option value="">-- Pilih Kepala Keluarga --</option>
                                            @foreach($kk as $data)
                                                <option 
                                                    value="{{ $data->jemaatKK->id_jemaat ?? '' }}" 
                                                    {{ (isset($item) && optional(optional($item->hubunganKeluarga)->kkJemaat)->id_kk_jemaat == optional($data)->id_kk_jemaat) || old('kk') == ($data->jemaatKK->id_jemaat ?? '') ? 'selected' : '' }}>
                                                    {{ $data->jemaatKK->nama_jemaat ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-control-label">Status Hubungan Keluarga</label>
                                    <select class="form-control select2-hidden-accessible" required data-toggle="select" name="status_aktif" @if(isset($item)) @endif>
                                        <option>--pilih--</option>
                                        <option value="Kepala Keluarga" 
                                            {{ (isset($item) && optional($item->hubunganKeluarga)->hubungan_keluarga != 'Kepala Keluarga') ? 'selected' : '' }}>
                                            Kepala Keluarga
                                        </option>
                                        <option value="Pasangan" 
                                            {{ (isset($item) && optional($item->hubunganKeluarga)->hubungan_keluarga == 'Pasangan') ? 'selected' : '' }}>
                                            Pasangan
                                        </option>
                                        <option value="Anak" 
                                            {{ (isset($item) && optional($item->hubunganKeluarga)->hubungan_keluarga == 'Anak') ? 'selected' : '' }}>
                                            Anak
                                        </option>
                                        <option value="Kerabat" 
                                            {{ (isset($item) && optional($item->hubunganKeluarga)->hubungan_keluarga == 'Kerabat') ? 'selected' : '' }}>
                                            Kerabat
                                        </option>
                                        <option value="Belum Menikah" 
                                            {{ (isset($item) && optional($item->hubunganKeluarga)->hubungan_keluarga == 'Belum Menikah') ? 'selected' : '' }}>
                                            Belum Menikah
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success bg-gradient-success btn-md"> Simpan </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('.select2').select2({
                        placeholder: "Cari Kepala Keluarga...",
                        allowClear: true
                    });
                });
            </script>
        @endpush


        <!-- Modal Structure -->

        @include('layouts.footers.auth.footer')
    </div>

    @endsection
