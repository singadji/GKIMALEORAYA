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

    <div class="card mb-4" style="background: linear-gradient(135deg, #7c2d12 0%, #c2410c 50%, #ea580c 100%); border-radius: 12px; border: none;">
        <div class="card-body py-4 px-5">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="text-white mb-1" style="font-weight: 700; letter-spacing: 0.5px;">
                        <i class="fas fa-plus-circle me-2"></i>{{ $subjudul }}
                    </h3>
                    <p class="text-white-50 mb-0" style="font-size: 0.9rem;">
                        Tambah data atestasi keluar pindah jemaat baru
                    </p>
                </div>
                <div class="col-auto text-end">
                    <a href="{{ route('administrasi.pindah-gereja-keluar.index') }}"
                       class="btn btn-light btn-sm" style="border-radius: 0.5rem;">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-10 border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('administrasi.pindah-gereja-keluar.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            <i class="fas fa-exchange-alt me-1 text-primary"></i> Jenis <span class="text-danger">*</span>
                        </label>
                        <select name="jenis" id="jenis" class="form-control" required
                                style="border-radius: 0.5rem;">
                            <option value="pindah" {{ old('jenis') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                            <option value="atestasi_keluar" {{ old('jenis') == 'atestasi_keluar' ? 'selected' : '' }}>Atestasi Keluar</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="id_jemaat" class="form-label fw-bold">
                            <i class="fas fa-user me-1 text-primary"></i> Pilih Jemaat <span class="text-danger">*</span>
                        </label>
                        <select name="id_jemaat" id="id_jemaat" class="form-control" required
                                style="border-radius: 0.5rem;">
                            <option value="">-- Pilih Jemaat --</option>
                            @foreach($jemaatList as $jemaat)
                                <option value="{{ $jemaat->id_jemaat }}"
                                    data-nia="{{ $jemaat->nia }}"
                                    data-gender="{{ $jemaat->gender }}"
                                    {{ old('id_jemaat') == $jemaat->id_jemaat ? 'selected' : '' }}>
                                    {{ $jemaat->nia }} - {{ $jemaat->nama_jemaat }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_jemaat')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="nia" class="form-label fw-bold">
                            <i class="fas fa-id-card me-1 text-info"></i> NIA
                        </label>
                        <input type="text" id="nia" class="form-control" readonly
                               style="border-radius: 0.5rem; background-color: #f8f9fa;">
                    </div>

                    <div class="col-md-3">
                        <label for="gender" class="form-label fw-bold">
                            <i class="fas fa-venus-mars me-1 text-warning"></i> Jenis Kelamin
                        </label>
                        <input type="text" id="gender" class="form-control" readonly
                               style="border-radius: 0.5rem; background-color: #f8f9fa;">
                    </div>

                    <div class="col-md-4">
                        <label for="tanggal" class="form-label fw-bold">
                            <i class="fas fa-calendar-alt me-1 text-primary"></i> Tanggal Pindah <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required
                               value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                               style="border-radius: 0.5rem;">
                        @error('tanggal')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="gereja" class="form-label fw-bold">
                            <i class="fas fa-church me-1 text-success"></i> Gereja Tujuan <span class="text-danger">*</span>
                        </label>
                        <textarea name="gereja" id="gereja" class="form-control" required rows="4"
                                  placeholder="Nama gereja tujuan pindah"
                                  style="border-radius: 0.5rem;">{{ old('gereja') }}</textarea>
                        @error('gereja')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('administrasi.pindah-gereja-keluar.index') }}"
                       class="btn btn-secondary" style="border-radius: 0.5rem;">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-warning" style="border-radius: 0.5rem;">
                        <i class="fas fa-save me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('layouts.footers.auth.footer')

</div>

@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#id_jemaat').select2({
            width: '100%',
            placeholder: '-- Ketik NIA atau Nama Jemaat --',
            allowClear: true,
            minimumInputLength: 0,
            dropdownAutoWidth: true
        });

        $('#id_jemaat').on('select2:open', function() {
            setTimeout(function() {
                document.querySelector('.select2-search__field').focus();
            }, 0);
        });

        $('#id_jemaat').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var nia = selectedOption.data('nia') || '';
            var gender = selectedOption.data('gender') || '';
            $('#nia').val(nia);
            $('#gender').val(gender === 'L' ? 'Laki-laki' : (gender === 'P' ? 'Perempuan' : gender));
        });

        if ($('#id_jemaat').val()) {
            $('#id_jemaat').trigger('change');
        }
    });
</script>
@endpush
