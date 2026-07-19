@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav')
@php
    use Carbon\Carbon;
@endphp

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
                        <i class="fas fa-file-alt me-2"></i>{!! $Hjudul !!}
                    </h3>
                    <p class="text-white-50 mb-0" style="font-size: 0.9rem;">
                        Kelola data atestasi masuk dan keluar jemaat GKI Maleo Raya
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

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-xl-0 mb-3">
            <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #198754;">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(25,135,84,0.1); border-radius: 12px;">
                        <i class="fas fa-sign-in-alt text-success" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Total Atestasi Masuk</h6>
                        <h3 class="mb-0" style="font-weight: 700; color: #198754;">{{ $totalMasuk }}</h3>
                        <small class="text-muted">3 bulan terakhir</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-xl-0 mb-3">
            <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #dc3545;">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(220,53,69,0.1); border-radius: 12px;">
                        <i class="fas fa-sign-out-alt text-danger" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Total Atestasi Keluar</h6>
                        <h3 class="mb-0" style="font-weight: 700; color: #dc3545;">{{ $totalKeluar }}</h3>
                        <small class="text-muted">3 bulan terakhir</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card shadow-sm h-100" style="border-radius: 12px; border-left: 4px solid #0d6efd;">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: rgba(13,110,253,0.1); border-radius: 12px;">
                        <i class="fas fa-file-alt text-primary" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Total Semua</h6>
                        <h3 class="mb-0" style="font-weight: 700; color: #0d6efd;">{{ $totalMasuk + $totalKeluar }}</h3>
                        <small class="text-muted">Rekap keseluruhan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter & Search Form --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body py-3 px-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px;">
            <form method="GET" action="{{ route('administrasi.atestasi.index') }}" id="filterForm">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="row align-items-end g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.8rem;">
                            <i class="fas fa-calendar-alt me-1 text-primary"></i> Tanggal Awal
                        </label>
                        <input type="date" name="tanggal_awal" class="form-control form-control-sm"
                               value="{{ $tanggalAwal ?? '' }}"
                               style="border-radius: 0.5rem;"
                               onchange="this.form.submit()">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.8rem;">
                            <i class="fas fa-calendar-alt me-1 text-danger"></i> Tanggal Akhir
                        </label>
                        <input type="date" name="tanggal_akhir" class="form-control form-control-sm"
                               value="{{ $tanggalAkhir ?? '' }}"
                               style="border-radius: 0.5rem;"
                               onchange="this.form.submit()">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.8rem;">
                            <i class="fas fa-search me-1 text-info"></i> Cari (NIA / Nama)
                        </label>
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" class="form-control"
                                   value="{{ $search ?? '' }}"
                                   placeholder="Cari NIA atau Nama Jemaat..."
                                   style="border-radius: 0.5rem 0 0 0.5rem;">
                            <button type="submit" class="btn btn-primary" style="border-radius: 0 0.5rem 0.5rem 0;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    @if(!empty($tanggalAwal) || !empty($search))
                        <div class="col-md-2">
                            <a href="{{ route('administrasi.atestasi.index', ['tab' => $tab]) }}"
                               class="btn btn-outline-secondary btn-sm w-100" style="border-radius: 0.5rem; height: 2.25rem;">
                                <i class="fas fa-times me-1"></i> Reset
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Active Filter Info --}}
    @if(!empty($tanggalAwal))
        <div class="d-flex align-items-center mb-3 p-3" style="border-left: 4px solid #0d47a1; background-color: #d6eaf8; border-radius: 8px;">
            <i class="fas fa-filter me-3" style="color:#0d47a1; font-size:1.2rem;"></i>
            <div style="color:#1a1a1a; font-size:0.85rem; line-height:1.6;">
                <strong style="color:#0d47a1;">Filter aktif:</strong>
                Menampilkan data atestasi {{ $tab === 'masuk' ? 'masuk' : 'keluar' }} tanggal
                <span class="badge" style="background-color:#0d47a1; color:#fff; font-size:0.8rem;">{{ Carbon::parse($tanggalAwal)->translatedFormat('d F Y') }}</span>
                s/d
                <span class="badge" style="background-color:#0d47a1; color:#fff; font-size:0.8rem;">{{ Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}</span>
                @if(!empty($search))
                    | Pencarian: <strong>{{ $search }}</strong>
                @endif
                — Ditemukan <strong>{{ $atestasi->total() }}</strong> data.
            </div>
        </div>
    @endif

    {{-- Tab Navigation --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header border-bottom-0 pb-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px 12px 0 0;">
            <ul class="nav nav-tabs nav-fill" id="atestasiTab" role="tablist" style="border-bottom: none;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $tab === 'masuk' ? 'active' : '' }}"
                            id="masuk-tab" data-bs-toggle="tab" data-bs-target="#masuk-pane"
                            type="button" role="tab"
                            onclick="window.location='{{ route('administrasi.atestasi.index', ['tab' => 'masuk', 'tanggal_awal' => $tanggalAwal, 'tanggal_akhir' => $tanggalAkhir, 'search' => $search]) }}'">
                        <i class="fas fa-sign-in-alt me-1"></i> Atestasi Masuk
                        <span class="badge bg-success ms-1">{{ $totalMasuk }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $tab === 'keluar' ? 'active' : '' }}"
                            id="keluar-tab" data-bs-toggle="tab" data-bs-target="#keluar-pane"
                            type="button" role="tab"
                            onclick="window.location='{{ route('administrasi.atestasi.index', ['tab' => 'keluar', 'tanggal_awal' => $tanggalAwal, 'tanggal_akhir' => $tanggalAkhir, 'search' => $search]) }}'">
                        <i class="fas fa-sign-out-alt me-1"></i> Atestasi Keluar
                        <span class="badge bg-danger ms-1">{{ $totalKeluar }}</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body pt-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <a href="{{ route('administrasi.atestasi.create', ['type' => $tab]) }}"
                       class="btn btn-{{ $tab === 'masuk' ? 'success' : 'danger' }} btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Atestasi {{ ucfirst($tab) }}
                    </a>
                    <a href="{{ route('laporan.detail', 'atestasi-' . $tab) }}"
                       class="btn btn-outline-primary btn-sm ms-2" target="_blank">
                        <i class="fas fa-chart-bar me-1"></i> Lihat Laporan
                    </a>
                </div>
                <div>
                    <button onclick="exportTableToExcel('dataTable', 'atestasi_{{ $tab }}_{{ date('Ymd') }}.xlsx')"
                            class="btn btn-outline-success btn-sm">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </button>
                    <button onclick="printTable('dataTable', 'Data Atestasi {{ ucfirst($tab) }}')"
                            class="btn btn-outline-primary btn-sm ms-2">
                        <i class="fas fa-print me-1"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="card mb-10 border-0 shadow-sm">
        <div class="card-header border-bottom-0 pb-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center justify-content-between py-2">
                <h6 class="mb-0 text-dark">
                    <i class="fas fa-table me-2 text-primary"></i>Daftar Atestasi {{ ucfirst($tab) }}
                </h6>
                <span class="badge bg-primary px-3 py-2">
                    Total: {{ number_format($atestasi->total()) }} records
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
                            <th>N I A</th>
                            <th>Nama Jemaat</th>
                            <th class="text-center" style="width: 60px;">L/P</th>
                            <th class="text-center" style="width: 60px;">Wil.</th>
                            <th>Tanggal Atestasi</th>
                            <th>Gereja Asal / Tujuan</th>
                            <th>Alamat</th>
                            <th class="text-center" style="width: 120px;">No. Telepon/HP</th>
                            <th>Keterangan</th>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($atestasi as $index => $item)
                                                    @php $no = ($atestasi->currentPage() - 1) * $atestasi->perPage() + $index + 1; @endphp
                                                    <tr style="cursor: pointer; transition: background 0.2s;"
                                                        onmouseover="this.style.background='#f0f4ff'"
                                                        onmouseout="this.style.background='transparent'">
                                                        <td class="text-center text-muted">{{ $no }}</td>
                                                        <td>
                                                            <span class="font-weight-bold text-dark">{{ $item->nia ?? '-' }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="font-weight-500">{{ $item->nama_jemaat ?? '-' }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            @if($item->gender == 'L')
                                                                <span class="badge bg-info" style="font-size: 0.75rem;">
                                                                    <i class="fas fa-mars me-1"></i>L
                                                                </span>
                                                            @elseif($item->gender == 'P')
                                                                <span class="badge bg-danger" style="font-size: 0.75rem;">
                                                                    <i class="fas fa-venus me-1"></i>P
                                                                </span>
                                                            @else
                                                                <span class="badge bg-secondary" style="font-size: 0.75rem;">{{ $item->gender }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-outline-primary px-2 py-1" style="border: 1.5px solid #5e72e4; color: #5e72e4; background: rgba(94,114,228,0.08); font-size: 0.75rem;">
                                                                {{ $item->id_group_wilayah ?? '-' }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="font-weight-500">
                                                                {{ $item->tanggal ? Carbon::parse($item->tanggal)->translatedFormat('d F Y') : '-' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="text-dark">{{ $item->gereja ?? '-' }}</span>
                                                        </td>
                                                        <td style="max-width: 200px; white-space: normal; word-wrap: break-word;">
                                                            <span class="text-muted">{{ $item->alamat ?? '-' }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="text-muted">{{ $item->telepon ?? '-' }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">{{ $item->keterangan ?? '-' }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{ route('administrasi.atestasi.edit', $item->id_atestasi) }}"
                                                                   class="btn btn-outline-primary" title="Edit"
                                                                   data-bs-toggle="tooltip">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <a href="{{ route('administrasi.atestasi.cetak', [$item->id_atestasi, $tab]) }}"
                                                                   class="btn btn-outline-danger" title="Cetak Surat"
                                                                   target="_blank" data-bs-toggle="tooltip">
                                                                    <i class="fas fa-file-pdf"></i>
                                                                </a>
                                                                <form action="{{ route('administrasi.atestasi.destroy', $item->id_atestasi) }}"
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
                                            Tidak ada data atestasi {{ $tab === 'masuk' ? 'masuk' : 'keluar' }}
                                        </p>
                                        <a href="{{ route('administrasi.atestasi.create', ['type' => $tab]) }}"
                                           class="btn btn-{{ $tab === 'masuk' ? 'success' : 'danger' }} btn-sm mt-3">
                                            <i class="fas fa-plus me-1"></i> Tambah Data Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="card-footer border-top-0 py-3" style="background: transparent;">
                <div class="d-flex justify-content-center">
                    {{ $atestasi->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth.footer')

</div>

@endsection

@push('scripts')
<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [[5, "desc"]], // Sort by Tanggal Atestasi column (index 5)
            "pageLength": 15,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            },
            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                   "<'row'<'col-sm-12'tr>>" +
                   "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "columnDefs": [
                { "orderable": false, "targets": [0, 10] } // Disable sorting on # and Aksi columns
            ]
        });

        // Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // Export to Excel
    function exportTableToExcel(tableID, filename = '') {
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

        // Specify file name
        filename = filename ? filename + '.xls' : 'excel_data.xls';

        // Create download link element
        downloadLink = document.createElement("a");
        document.body.appendChild(downloadLink);

        if (navigator.msSaveOrOpenBlob) {
            var blob = new Blob(['\ufeff', tableHTML], { type: dataType });
            navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
            downloadLink.download = filename;
            downloadLink.click();
        }
    }

    // Print table
    function printTable(tableID, title = '') {
        var printWindow = window.open('', '', 'height=600,width=900');
        var tableHTML = document.getElementById(tableID).outerHTML;
        var style = '<style>table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #ddd; padding: 8px; text-align: left; } th { background-color: #f2f2f2; } @page { size: landscape; }</style>';
        printWindow.document.write('<html><head><title>' + title + '</title>' + style + '</head><body>');
        printWindow.document.write('<h2 style="text-align:center;">' + title + '</h2>');
        printWindow.document.write('<p style="text-align:center;">Dicetak pada: ' + new Date().toLocaleDateString('id-ID') + '</p>');
        printWindow.document.write(tableHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }
</script>
@endpush
