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

    <div class="card mb-4" style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 50%, #3b82f6 100%); border-radius: 12px; border: none;">
        <div class="card-body py-4 px-5">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="text-white mb-1" style="font-weight: 700; letter-spacing: 0.5px;">
                        <i class="fas fa-edit me-2"></i>{{ $subjudul }}
                    </h3>
                    <p class="text-white-50 mb-0" style="font-size: 0.9rem;">
                        Perbarui data modul admin panel
                    </p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.modul.index') }}"
                       class="btn btn-light btn-sm" style="border-radius: 0.5rem;">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.modul.update', $modul) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_modul" class="form-label fw-bold">
                            <i class="fas fa-tag me-1 text-primary"></i> Nama Modul <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_modul" id="nama_modul" class="form-control form-control-sm" required
                               value="{{ old('nama_modul', $modul->nama_modul) }}"
                               placeholder="Contoh: Data Jemaat"
                               style="border-radius: 0.5rem;"
                               oninput="autoSlug(this.value)">
                        @error('nama_modul')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="slug" class="form-label fw-bold">
                            <i class="fas fa-link me-1 text-info"></i> Slug
                        </label>
                        <input type="text" name="slug" id="slug" class="form-control form-control-sm"
                               value="{{ old('slug', $modul->slug) }}"
                               placeholder="auto-generate"
                               style="border-radius: 0.5rem;">
                        @error('slug')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="icon" class="form-label fw-bold">
                            <i class="fas fa-icons me-1 text-warning"></i> Icon <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="icon" id="icon" class="form-control form-control-sm" required
                               value="{{ old('icon', $modul->icon) }}"
                               placeholder="Contoh: settings"
                               style="border-radius: 0.5rem;">
                        @error('icon')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="link_modul" class="form-label fw-bold">
                            <i class="fas fa-external-link-alt me-1 text-success"></i> Link Modul <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="link_modul" id="link_modul" class="form-control form-control-sm" required
                               value="{{ old('link_modul', $modul->link_modul) }}"
                               placeholder="Gunakan '#' untuk parent menu"
                               style="border-radius: 0.5rem;">
                        <small class="text-muted">Gunakan <code>#</code> untuk menu parent (dropdown)</small>
                        @error('link_modul')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="par" class="form-label fw-bold">
                            <i class="fas fa-sitemap me-1 text-secondary"></i> Parent
                        </label>
                        <select name="par" id="par" class="form-control form-control-sm select2"
                                style="border-radius: 0.5rem;">
                            <option value="0">-- Root (Level Atas) --</option>
                            @foreach($parentList as $parent)
                                <option value="{{ $parent->id_modul }}"
                                    {{ old('par', $modul->par) == $parent->id_modul ? 'selected' : '' }}>
                                    {{ $parent->nama_modul }}
                                </option>
                            @endforeach
                        </select>
                        @error('par')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="folder" class="form-label fw-bold">
                            <i class="fas fa-folder me-1 text-secondary"></i> Folder
                        </label>
                        <input type="text" name="folder" id="folder" class="form-control form-control-sm"
                               value="{{ old('folder', $modul->folder) }}"
                               placeholder="Contoh: administrasi"
                               style="border-radius: 0.5rem;">
                        @error('folder')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="role" class="form-label fw-bold">
                            <i class="fas fa-user-shield me-1 text-danger"></i> Role <span class="text-danger">*</span>
                        </label>
                        <select name="role" id="role" class="form-control form-control-sm" required
                                style="border-radius: 0.5rem;">
                            <option value="Administrator" {{ old('role', $modul->role) == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                            <option value="User" {{ old('role', $modul->role) == 'User' ? 'selected' : '' }}>User</option>
                            <option value="Pangan" {{ old('role', $modul->role) == 'Pangan' ? 'selected' : '' }}>Pangan</option>
                            <option value="Pertanian" {{ old('role', $modul->role) == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                            <option value="Peternakan" {{ old('role', $modul->role) == 'Peternakan' ? 'selected' : '' }}>Peternakan</option>
                        </select>
                        @error('role')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-toggle-on me-1 text-success"></i> Status
                        </label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="aktif" id="aktif_y"
                                       value="Y" {{ old('aktif', $modul->aktif) == 'Y' ? 'checked' : '' }}>
                                <label class="form-check-label" for="aktif_y">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="aktif" id="aktif_t"
                                       value="T" {{ old('aktif', $modul->aktif) == 'T' ? 'checked' : '' }}>
                                <label class="form-check-label" for="aktif_t">Nonaktif</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-globe me-1 text-info"></i> Publish
                        </label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="publish" id="publish_y"
                                       value="Y" {{ old('publish', $modul->publish) == 'Y' ? 'checked' : '' }}>
                                <label class="form-check-label" for="publish_y">Ya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="publish" id="publish_t"
                                       value="T" {{ old('publish', $modul->publish) == 'T' ? 'checked' : '' }}>
                                <label class="form-check-label" for="publish_t">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.modul.index') }}"
                       class="btn btn-secondary btn-sm" style="border-radius: 0.5rem;">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm" style="border-radius: 0.5rem;">
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
        $('#par').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: '-- Root (Level Atas) --',
            allowClear: true
        });
    });

    function autoSlug(val) {
        var slug = val.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        document.getElementById('slug').value = slug;
    }
</script>
@endpush
