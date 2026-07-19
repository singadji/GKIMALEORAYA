@php
    $kkStats = $stats ?? [];
    $totalKkAktif = $kkStats['total'] ?? $item->count();
    $totalKkKeseluruhan = $kkStats['total_keseluruhan'] ?? $totalKkAktif;
    $totalAnggota = $kkStats['total_anggota'] ?? 0;
    $problematicCount = $kkStats['problematic'] ?? 0;
    $selisihKk = $totalKkKeseluruhan - $totalKkAktif;
@endphp

<style>
    .kk-page {
        position: relative;
        z-index: 1;
        padding-bottom: 1.75rem;
    }

    .kk-panel {
        border: 0;
        border-radius: .45rem;
        box-shadow: 0 .45rem 1.5rem rgba(50, 50, 93, .08), 0 .15rem .45rem rgba(0, 0, 0, .04);
        overflow: visible;
    }

    .kk-panel-header {
        padding: 1.9rem 2rem 1rem;
        background: #fff;
        border-radius: .45rem .45rem 0 0;
    }

    .kk-panel-title {
        color: #344767;
        font-size: 1.08rem;
        font-weight: 600;
        margin: 0;
    }

    .kk-panel-rule {
        border: 0;
        border-top: 1px solid #edf0f5;
        margin: 1.1rem 0 1.2rem;
    }

    .kk-stat {
        min-height: 62px;
        border-left: 3px solid var(--kk-color);
        border-radius: .45rem;
        background: #fff;
        box-shadow: 0 .25rem 1rem rgba(50, 50, 93, .06);
        display: flex;
        align-items: center;
        padding: .72rem .82rem;
    }

    .kk-stat-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--kk-soft);
        color: var(--kk-color);
        margin-right: .65rem;
        flex: 0 0 auto;
    }

    .kk-stat-label {
        color: #67748e;
        font-size: .56rem;
        font-weight: 700;
        letter-spacing: .03rem;
        line-height: 1.2;
        margin-bottom: .15rem;
        text-transform: uppercase;
    }

    .kk-stat-value {
        color: var(--kk-color);
        font-size: .98rem;
        font-weight: 700;
        line-height: 1;
        margin: 0;
    }

    .kk-note {
        background: #d9edf8;
        border-left: 3px solid #1769aa;
        border-radius: .25rem;
        color: #344767;
        font-size: .7rem;
        line-height: 1.55;
        margin: 1.45rem 0 .15rem;
        padding: .7rem .8rem;
    }

    .kk-note i {
        color: #1769aa;
        margin-right: .3rem;
    }

    .kk-note code {
        background: rgba(255, 255, 255, .7);
        border-radius: .15rem;
        color: #1769aa;
        font-size: .68rem;
        padding: .1rem .25rem;
    }

    .kk-note-action {
        background: #c0392b;
        border-radius: .2rem;
        color: #fff !important;
        display: inline-block;
        font-size: .63rem;
        font-weight: 700;
        margin-top: .25rem;
        padding: .18rem .45rem;
        text-decoration: none !important;
    }

    .kk-table-wrap {
        padding: .2rem 2rem 1.7rem;
    }

    .kk-table-scroll {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .kk-table-wrap div.dataTables_wrapper div.dataTables_length,
    .kk-table-wrap div.dataTables_wrapper div.dataTables_filter,
    .kk-table-wrap div.dataTables_wrapper div.dt-buttons {
        margin-bottom: .75rem;
    }

    .kk-table-wrap .dataTables_length,
    .kk-table-wrap .dataTables_filter {
        color: #525f7f;
        font-size: .7rem;
    }

    .kk-table-wrap .dataTables_length select,
    .kk-table-wrap .dataTables_filter input {
        border: 1px solid #dfe3e8;
        border-radius: .2rem;
        color: #525f7f;
        font-size: .7rem;
        height: 1.8rem;
        margin: 0 .25rem;
        padding: .15rem .35rem;
    }

    .kk-table-wrap .dataTables_filter {
        text-align: right;
    }

    .kk-table-wrap .dataTables_filter input {
        min-width: 120px;
    }

    .kk-table-wrap .dt-buttons {
        display: inline-flex;
        gap: .35rem;
        justify-content: center;
        width: 100%;
    }

    .kk-table-wrap .dt-buttons .btn {
        border: 0;
        border-radius: .2rem;
        font-size: .62rem;
        line-height: 1.2;
        margin: 0;
        padding: .35rem .55rem;
    }

    .kk-table {
        border-collapse: separate;
        border-spacing: 0;
        color: #344767;
        font-size: .66rem;
        margin-top: .3rem !important;
        min-width: 860px;
        width: 100% !important;
        border-radius: .45rem;
        overflow: hidden;
    }

    .kk-table thead th {
        background: #0d8dce;
        border: 0;
        color: #fff;
        font-size: .58rem;
        font-weight: 700;
        letter-spacing: .04rem;
        line-height: 1.2;
        padding: .68rem .65rem;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .kk-table tbody td {
        border-bottom: 1px solid #edf0f5;
        line-height: 1.28;
        padding: .68rem .65rem;
        vertical-align: middle;
    }

    .kk-table tbody tr:last-child td:first-child { border-bottom-left-radius: .45rem; }
    .kk-table tbody tr:last-child td:last-child { border-bottom-right-radius: .45rem; }

    .kk-table tbody tr { cursor: pointer; transition: background .15s ease; }
    .kk-table tbody tr:hover { background: #f4fbff; }

    .kk-name { color: #252f40; font-weight: 700; }

    .kk-nia,
    .kk-gender {
        white-space: nowrap;
    }

    .kk-address {
        display: block;
        line-height: 1.3;
        max-width: 300px;
        white-space: normal;
    }

    .kk-wilayah {
        color: #0d8dce;
        font-weight: 700;
        white-space: nowrap;
    }

    .kk-wilayah i { margin-right: .2rem; }

    .kk-members {
        background: #2dcc8c;
        border-radius: 1rem;
        color: #fff;
        display: inline-block;
        font-size: .56rem;
        font-weight: 700;
        min-width: 46px;
        padding: .23rem .43rem;
        text-align: center;
        white-space: nowrap;
    }

    .kk-members.is-empty {
        background: transparent;
        color: #67748e;
        font-weight: 600;
        padding-left: 0;
        padding-right: 0;
    }

    .kk-table-wrap .dataTables_info,
    .kk-table-wrap .dataTables_paginate {
        color: #67748e;
        font-size: .67rem;
        padding-top: 1rem;
    }

    .kk-table-wrap .pagination { margin: 0; }
    .kk-table-wrap .page-item .page-link {
        border: 0;
        border-radius: .25rem;
        color: #525f7f;
        font-size: .68rem;
        height: 1.65rem;
        line-height: 1.65rem;
        margin: 0 .08rem;
        min-width: 2rem;
        padding: 0 .4rem;
        text-align: center;
    }

    .kk-table-wrap .page-item.active .page-link {
        background: #0d8dce;
        color: #fff;
    }

    .kk-table-wrap table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before,
    .kk-table-wrap table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before {
        background-color: #0d8dce;
        border: 0;
        box-shadow: none;
        top: 50%;
        transform: translateY(-50%);
    }

    @media (max-width: 991.98px) {
        .kk-table-wrap .dataTables_filter,
        .kk-table-wrap div.dataTables_wrapper div.dataTables_length,
        .kk-table-wrap div.dataTables_wrapper div.dataTables_filter {
            text-align: left;
        }

        .kk-table-wrap .dt-buttons {
            justify-content: flex-start;
        }
    }

    @media (max-width: 767.98px) {
        .kk-panel-header, .kk-table-wrap { padding-left: 1rem; padding-right: 1rem; }
        .kk-note { font-size: .68rem; }
        .kk-table { min-width: 860px; }
        .kk-table-wrap .dataTables_filter input { width: calc(100% - 38px); }
        .kk-table-wrap .dt-buttons { flex-wrap: wrap; }
    }
</style>

<div class="container-fluid mt--6">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    @if(isset($item))
                    <div class="table-responsive p-4" style="overflow-x:auto; overflow-y:auto;" id="DW">
                        {!! $Hjudul !!}
                        <div id="tableLoader">
                            <table class="table align-items-center mb-2 table-hover" style="width:100%; line-height:1.3;">
                                <thead>
                                    <tr>
                                        <th style="background:#f2f2f2;">#</th>
                                        <th style="background:#f2f2f2;">NIA</th>
                                        <th style="background:#f2f2f2;">Nama Kepala Keluarga</th>
                                        <th style="background:#f2f2f2;">L/P</th>
                                        <th style="background:#f2f2f2;">Alamat</th>
                                        <th style="background:#f2f2f2;">Wilayah</th>
                                        <th style="background:#f2f2f2;">Anggota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = 0; $i < 8; $i++)
                                    <tr>
                                        <td><div class="skeleton-line" style="width:20px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                        <td><div class="skeleton-line" style="width:60px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                        <td><div class="skeleton-line" style="width:140px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                        <td><div class="skeleton-line" style="width:25px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                        <td><div class="skeleton-line" style="width:180px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                        <td><div class="skeleton-line" style="width:30px;height:14px;background:#e9ecef;border-radius:4px;"></div></td>
                                        <td><div class="skeleton-line" style="width:50px;height:22px;background:#e9ecef;border-radius:12px;"></div></td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                            <style>
                                @keyframes shimmer { 0% { background-position: -400px 0; } 100% { background-position: 400px 0; } }
                                .skeleton-line { background: linear-gradient(90deg, #e9ecef 25%, #f8f9fa 50%, #e9ecef 75%); background-size: 800px 100%; animation: shimmer 1.5s infinite; }
                            </style>
                        </div>

                        <table id="dataTable" class="kk-table display table table-hover nowrap" data-excluded-columns="0" aria-label="Data kepala keluarga">
                            <thead>
                                <tr>
                                    <th class="text-center" width="50">#</th>
                                    <th width="100">NIA</th>
                                    <th width="200">Nama Kepala Keluarga</th>
                                    <th class="text-center" width="60">L/P</th>
                                    <th width="250">Alamat</th>
                                    <th width="120">Wilayah Pelayanan</th>
                                    <th class="text-center" width="80">Anggota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($item as $row)
                                    @php
                                        $anggota = $row->kkJemaat?->anggotaKeluarga?->count() ?? 0;
                                        $alamat = $row->kkJemaat?->alamat ?: '-';
                                    @endphp
                                    <tr onclick="window.location='{{ route('administrasi.data-jemaat.show', $row->id_jemaat) }}';">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="font-weight-bold kk-nia">{{ $row->nia }}</td>
                                        <td class="kk-name">{{ $row->nama_jemaat }}</td>
                                        <td class="text-center kk-gender">{{ $row->gender }}</td>
                                        <td><span class="kk-address">{{ $alamat }}</span></td>
                                        <td class="kk-wilayah"><i class="fas fa-map-marker-alt"></i>{{ $row->nama_wilayah ?? '-' }}</td>
                                        <td class="text-center">
                                            @if($anggota > 0)
                                                <span class="kk-members">{{ $anggota }} ORANG</span>
                                            @else
                                                <span class="kk-members is-empty">0</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var observer = setInterval(function () {
            if (typeof $.fn.DataTable !== 'undefined' && $.fn.DataTable.isDataTable('#dataTable')) {
                clearInterval(observer);
                var loader = document.getElementById('tableLoader');
                var dt = document.getElementById('dataTable');
                if (loader) loader.style.display = 'none';
                if (dt) dt.style.display = '';
            }
        }, 100);
    });
</script>
