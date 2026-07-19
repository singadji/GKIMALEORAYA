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

    {{-- Page Header Card --}}
    <div class="card mb-4" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); border-radius: 12px; border: none;">
        <div class="card-body py-4 px-5">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="text-white mb-1" style="font-weight: 700; letter-spacing: 0.5px;">
                        <i class="fas fa-edit me-2"></i>{{ $subjudul }}
                    </h3>
                    <p class="text-white-50 mb-0" style="font-size: 0.9rem;">
                        Perbarui data atestasi {{ $type === 'masuk' ? 'masuk' : 'keluar' }} jemaat
                    </p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('administrasi.atestasi.index', ['tab' => $type]) }}"
                       class="btn btn-light btn-sm" style="border-radius: 0.5rem;">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('administrasi.atestasi.update', $atestasi) }}" id="atestasiForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" value="{{ $type }}">

                <div class="row g-3">
                    {{-- Current Jemaat Info --}}
                    <div class="col-12">
                        <div class="alert alert-info mb-3" style="border-radius: 0.5rem;">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Jemaat Saat Ini:</strong> 
                            {{ $atestasi->jemaatAtestasi->nia }} - {{ $atestasi->jemaatAtestasi->nama_jemaat }}
                            ({{ $atestasi->jemaatAtestasi->gender === 'L' ? 'Laki-laki' : 'Perempuan' }})
                        </div>
                    </div>

                    {{-- Jemaat Selection --}}
                    <div class="col-md-6">
                        <label for="id_jemaat" class="form-label fw-bold">
                            <i class="fas fa-user me-1 text-primary"></i> Pilih Jemaat <span class="text-danger">*</span>
                        </label>
                        <select name="id_jemaat" id="id_jemaat" class="form-select form-select-sm select2" required
                                style="border-radius: 0.5rem;">
                            <option value="">-- Pilih Jemaat --</option>
                            @foreach($jemaatList as $jemaat)
                                                            <option value="{{ $jemaat->id_jemaat }}"
                                                                data-nia="{{ $jemaat->nia }}"
                                                                data-gender="{{ $jemaat->gender }}"
                                                                {{ old('id_jemaat', $atestasi->id_jemaat) == $jemaat->id_jemaat ? 'selected' : '' }}>
                                                                {{ $jemaat->nia }} - {{ $jemaat->nama_jemaat }}
                                                            </option>
                                                        @endforeach
                        </select>
                        @error('id_jemaat')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Auto-filled NIA --}}
                    <div class="col-md-3">
                        <label for="nia" class="form-label fw-bold">
                            <i class="fas fa-id-card me-1 text-info"></i> NIA
                        </label>
                        <input type="text" id="nia" class="form-control form-control-sm" readonly
                               value="{{ $atestasi->jemaatAtestasi->nia }}"
                               style="border-radius: 0.5rem; background-color: #f8f9fa;">
                    </div>

                    {{-- Auto-filled Gender --}}
                    <div class="col-md-3">
                        <label for="gender" class="form-label fw-bold">
                            <i class="fas fa-venus-mars me-1 text-warning"></i> Jenis Kelamin
                        </label>
                        <input type="text" id="gender" class="form-control form-control-sm" readonly
                               value="{{ $atestasi->jemaatAtestasi->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}"
                               style="border-radius: 0.5rem; background-color: #f8f9fa;">
                    </div>

                    {{-- Tanggal Atestasi --}}
                    <div class="col-md-4">
                        <label for="tanggal" class="form-label fw-bold">
                            <i class="fas fa-calendar-alt me-1 text-primary"></i> Tanggal Atestasi <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control form-control-sm" required
                               value="{{ old('tanggal', $atestasi->tanggal->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                               style="border-radius: 0.5rem;">
                        @error('tanggal')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Gereja Asal/Tujuan --}}
                    <div class="col-md-8">
                        <label for="gereja" class="form-label fw-bold">
                            <i class="fas fa-church me-1 text-success"></i> 
                            {{ $type === 'masuk' ? 'Gereja Asal' : 'Gereja Tujuan' }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="gereja" id="gereja" class="form-control form-control-sm" required
                               value="{{ old('gereja', $atestasi->gereja) }}"
                               placeholder="{{ $type === 'masuk' ? 'Nama gereja asal jemaat' : 'Nama gereja tujuan jemaat' }}"
                               style="border-radius: 0.5rem;">
                        @error('gereja')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div class="col-12">
                        <label for="keterangan" class="form-label fw-bold">
                            <i class="fas fa-sticky-note me-1 text-secondary"></i> Keterangan
                        </label>
                        <textarea name="keterangan" id="keterangan" class="form-control form-control-sm"
                                  rows="3" placeholder="Catatan tambahan (opsional)"
                                  style="border-radius: 0.5rem;">{{ old('keterangan', $atestasi->keterangan) }}</textarea>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('administrasi.atestasi.index', ['tab' => $type]) }}"
                       class="btn btn-secondary btn-sm" style="border-radius: 0.5rem;">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-{{ $type === 'masuk' ? 'success' : 'danger' }} btn-sm" style="border-radius: 0.5rem;">
                        <i class="fas fa-save me-1"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('layouts.footers.auth.footer')

</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#id_jemaat').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: '-- Pilih Jemaat --',
            allowClear: true
        });

        // Auto-fill NIA and Gender when jemaat is selected
        $('#id_jemaat').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var nia = selectedOption.data('nia') || '';
            var gender = selectedOption.data('gender') || '';
            
            $('#nia').val(nia);
            $('#gender').val(gender === 'L' ? 'Laki-laki' : (gender === 'P' ? 'Perempuan' : gender));
        });

        // Trigger change if pre-selected
        if ($('#id_jemaat').val()) {
            $('#id_jemaat').trigger('change');
        }
    });
</script>
@endpush