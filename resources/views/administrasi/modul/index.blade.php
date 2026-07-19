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
                        <i class="fas fa-th-large me-2"></i>{!! $Hjudul !!}
                    </h3>
                    <p class="text-white-50 mb-0" style="font-size: 0.9rem;">
                        Kelola modul dan menu navigasi admin panel
                    </p>
                </div>
                <div class="col-auto text-end">
                    <span class="badge" style="background: rgba(255,255,255,0.15); font-size: 0.85rem; padding: 8px 16px; border-radius: 20px;">
                        <i class="fas fa-calendar-alt me-1"></i> {{ now()->translatedFormat('d F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-xl-0 mb-3">
            <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #2563eb;">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(37,99,235,0.1); border-radius: 12px;">
                        <i class="fas fa-th-list text-primary" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Total Modul</h6>
                        <h3 class="mb-0" style="font-weight: 700; color: #2563eb;">{{ $totalAll }}</h3>
                        <small class="text-muted">Semua data</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-xl-0 mb-3">
            <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #198754;">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(25,135,84,0.1); border-radius: 12px;">
                        <i class="fas fa-check-circle text-success" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Aktif</h6>
                        <h3 class="mb-0" style="font-weight: 700; color: #198754;">{{ $totalAktif }}</h3>
                        <small class="text-muted">Sedang aktif</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #dc3545;">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(220,53,69,0.1); border-radius: 12px;">
                        <i class="fas fa-times-circle text-danger" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Nonaktif</h6>
                        <h3 class="mb-0" style="font-weight: 700; color: #dc3545;">{{ $totalNonaktif }}</h3>
                        <small class="text-muted">Tidak aktif</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body py-3 px-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px;">
            <form method="GET" action="{{ route('admin.modul.index') }}">
                <div class="row align-items-end g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.8rem;">
                            <i class="fas fa-search me-1 text-info"></i> Cari Modul
                        </label>
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" class="form-control"
                                   value="{{ $search ?? '' }}"
                                   placeholder="Cari nama modul, slug, atau link..."
                                   style="border-radius: 0.5rem 0 0 0.5rem;">
                            <button type="submit" class="btn btn-primary" style="border-radius: 0 0.5rem 0.5rem 0;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    @if(!empty($search))
                        <div class="col-md-2">
                            <a href="{{ route('admin.modul.index') }}"
                               class="btn btn-outline-secondary btn-sm w-100" style="border-radius: 0.5rem; height: 2.25rem;">
                                <i class="fas fa-times me-1"></i> Reset
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body pt-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <a href="{{ route('admin.modul.create') }}"
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Modul
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-10 border-0 shadow-sm">
        <div class="card-header border-bottom-0 pb-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center justify-content-between py-2">
                <h6 class="mb-0 text-dark">
                    <i class="fas fa-table me-2 text-primary"></i>Daftar Modul Admin
                </h6>
                <span class="badge bg-primary px-3 py-2">
                    Total: {{ number_format($modul->total()) }} records
                </span>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="">
                <div id="alert">
                    @include('includes.alert')
                </div>
            </div>

            <div class="table-responsive p-4" style="overflow-x:auto; overflow-y:auto;">
                <table class="display table align-items-center mb-2 table-hover data-table" id="dataTable" style="width:100%; color:#333333; line-height: 1.3;">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th class="text-center" style="width: 60px;">Icon</th>
                            <th>Nama Modul</th>
                            <th>Slug</th>
                            <th>Link</th>
                            <th>Parent</th>
                            <th>Folder</th>
                            <th>Role</th>
                            <th class="text-center" style="width: 80px;">Aktif</th>
                            <th class="text-center" style="width: 80px;">Publish</th>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($modul as $index => $item)
                            @php $no = ($modul->currentPage() - 1) * $modul->perPage() + $index + 1; @endphp
                            <tr style="transition: background 0.2s;"
                                onmouseover="this.style.background='#f0f4ff'"
                                onmouseout="this.style.background='transparent'">
                                <td class="text-center text-muted">{{ $no }}</td>
                                <td class="text-center">
                                    <span class="badge" style="background: rgba(37,99,235,0.1); color: #2563eb; font-size: 0.75rem; padding: 5px 8px; border-radius: 6px;">
                                        {{ $item->icon }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->par == 0)
                                        <strong class="text-dark">{{ $item->nama_modul }}</strong>
                                    @else
                                        <span class="ms-3 text-muted">└─</span> {{ $item->nama_modul }}
                                    @endif
                                </td>
                                <td><code style="font-size: 0.8rem;">{{ $item->slug ?? '-' }}</code></td>
                                <td>
                                    @if($item->link_modul == '#')
                                        <span class="badge bg-secondary" style="font-size: 0.7rem;">Parent</span>
                                    @else
                                        <span class="text-muted">{{ $item->link_modul }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->par == 0)
                                        <span class="badge bg-primary" style="font-size: 0.7rem;">Root</span>
                                    @else
                                        <span class="text-muted">{{ $item->parent->nama_modul ?? '-' }}</span>
                                    @endif
                                </td>
                                <td><span class="text-muted">{{ $item->folder ?? '-' }}</span></td>
                                <td>
                                    @php
                                        $roleColors = [
                                            'Administrator' => 'danger',
                                            'User' => 'info',
                                            'Pangan' => 'success',
                                            'Pertanian' => 'warning',
                                            'Peternakan' => 'secondary',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $roleColors[$item->role] ?? 'secondary' }}" style="font-size: 0.7rem;">
                                        {{ $item->role }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.modul.toggle-aktif', $item->id_modul) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link p-0" title="Toggle Aktif">
                                            @if($item->aktif == 'Y')
                                                <span class="badge bg-success" style="font-size: 0.7rem; cursor:pointer;">AKTIF</span>
                                            @else
                                                <span class="badge bg-danger" style="font-size: 0.7rem; cursor:pointer;">NONAKTIF</span>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.modul.toggle-publish', $item->id_modul) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link p-0" title="Toggle Publish">
                                            @if($item->publish == 'Y')
                                                <span class="badge bg-success" style="font-size: 0.7rem; cursor:pointer;">YA</span>
                                            @else
                                                <span class="badge bg-secondary" style="font-size: 0.7rem; cursor:pointer;">TIDAK</span>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.modul.edit', $item->id_modul) }}"
                                           class="btn btn-outline-primary" title="Edit"
                                           data-bs-toggle="tooltip">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.modul.destroy', $item->id_modul) }}"
                                              method="POST" style="display: inline-block;"
                                              onsubmit="return confirm('{{ $text }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Hapus" data-bs-toggle="tooltip">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <div>
                                        <i class="fas fa-inbox" style="font-size: 2.5rem; color: #c4c9d4;"></i>
                                        <p class="mt-3 mb-0" style="color: #8898aa; font-weight: 500;">
                                            Tidak ada data modul
                                        </p>
                                        <a href="{{ route('admin.modul.create') }}"
                                           class="btn btn-primary btn-sm mt-3">
                                            <i class="fas fa-plus me-1"></i> Tambah Modul Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer border-top-0 py-3" style="background: transparent;">
                <div class="d-flex justify-content-center">
                    {{ $modul->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth.footer')

</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [[2, "asc"]],
            "pageLength": 20,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            },
            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                   "<'row'<'col-sm-12'tr>>" +
                   "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "columnDefs": [
                { "orderable": false, "targets": [0, 8, 9, 10] }
            ]
        });

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
