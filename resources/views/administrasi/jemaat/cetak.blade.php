<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Keluarga Jemaat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 5px;
        }

        h2, h4 {
            text-align: center;
            margin: 0;
        }

        .header {
            margin-bottom: 20px;
            text-align: center;
        }

        .section {
            margin-bottom: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }

        th, td {
            border: 0.5px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .no-border {
            border: none !important;
        }

        .text-center {
            text-align: center;
        }

        .signature {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>DATA KELUARGA JEMAAT</h2>
        <h4>GKI MALEO RAYA - BINTARO</h4>
    </div>

    <div class="section">
        <table class="table table-hover data-table wrap">
            <tr>
                <th>Nomor Induk Anggota</th>
                <td>
                    {{ $kepalaKeluarga->jemaatKK->nia }}
                </td>
            </tr>
            <tr>
                <th>Nama Kepala Keluarga</th>
                <td>
                    {{ $kepalaKeluarga->jemaatKK->nama_jemaat }}
                </td>
            </tr>
            <tr>
                <th width="150px">L / P</th>
                <td>
                    {{ ($kepalaKeluarga->jemaatKK->gender ?? '') == 'L' ? 'Laki-laki' : '' }}
                    {{ ($kepalaKeluarga->jemaatKK->gender ?? '') == 'P' ? 'Perempuan' : '' }}
                </td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>
                    {{ $kepalaKeluarga->alamat ?? 'Tidak Diketahui' }}
                </td>
            </tr>
            <tr>
                <th>Nomor Telepon / HP</th>
                <td>
                    {{ $kepalaKeluarga->jemaatKK->telepon ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>Tempat, Tanggal Lahir</th>
                <td>
                    {{ $kepalaKeluarga->jemaatKK->tempat_lahir ?? '-' }}, {{ optional($kepalaKeluarga->jemaatKK)->tanggal_lahir ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_lahir)->translatedFormat('d F Y') : '' }}
                </td>
            </tr>
            <tr>
                <th>Tanggal Baptis</th>
                <td>
                    {{ optional($kepalaKeluarga->jemaatKK)->tanggal_baptis ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_baptis)->translatedFormat('d F Y') : '' }}
                </td>
            </tr>
            <tr>
                <th>Tanggal Sidi</th>
                <td>
                    {{ optional($kepalaKeluarga->jemaatKK)->tanggal_sidi ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_sidi)->translatedFormat('d F Y') : '' }}
                </td>
            </tr>
            <tr>
                <th>Status dan Tanggal Pernikahan</th>
                <td>
                    {{ $kepalaKeluarga->jemaatKK->status_menikah }}, 
                            {{ optional($kepalaKeluarga->jemaatKK)->tanggal_nikah 
                                ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_nikah)->translatedFormat('d F Y') : '' }}
                </td>
            </tr>
            <tr>
                <th>Gereja Asal dan Tanggal Terdaftar</th>
                <td>
                    {{ $kepalaKeluarga->jemaatKK->asal_gereja ?? '-' }}, 
                        {{ optional($kepalaKeluarga->jemaatKK)->tanggal_terdaftar 
                                    ? \Carbon\Carbon::parse($kepalaKeluarga->jemaatKK->tanggal_terdaftar)->translatedFormat('d F Y') : '' }}
                </td>
            </tr>
            <tr>
                <th>Grup Wilayah</th>
                <td>
                    {{ $kepalaKeluarga->id_group_wilayah ?? '-' }}
                </td>
            </tr>
            <tr>
                <th>Status Keanggotaan</th>
                @php
                    $badgeClass = $kepalaKeluarga->jemaatKK->status_aktif == 'Aktif' ? 'bg-gradient-success' :
                                ($kepalaKeluarga->jemaatKK->status_aktif == 'Meninggal Dunia' ? 'bg-gradient-primary' : 'bg-gradient-danger');
                @endphp
                <td>
                    {{ $kepalaKeluarga->jemaatKK->status_aktif ?? '-' }} - {{ $kepalaKeluarga->jemaatKK->keterangan ?? '' }}
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <table class="table warping" id="tableBody">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center" style="width:50px">N I A</th>
                    <th class="text-center">Nama Jemaat</th>
                    <th class="text-center" style="width:50px">L / P</th>
                    <th class="text-center">Hubungan</th>
                    <th class="text-center">Tempat,<br> Tanggal Lahir</th>
                    <th class="text-center">Tanggal<br>Baptis</th>
                    <th class="text-center">Tanggal<br>Sidi</th>
                    <th class="text-center">Gereja Asal</th>
                    <th class="text-center">Tanggal<br>Terdaftar</th>
                    <th class="text-center">Status<br>Keanggotaan</th>
                    <th class="text-center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($anggotaKeluarga as $key => $anggota)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td class="text-center">{{ $anggota->jemaat->nia ?? 'Tidak Diketahui' }}</td>
                        <td>{{ $anggota->jemaat->nama_jemaat ?? 'Tidak Diketahui' }}</td>
                        <td class="text-center">{{$anggota->jemaat->gender}}</td>
                        <td class="text-center">{{ $anggota->hubungan_keluarga }}</td>
                        <td class="text-center">{{ $anggota->jemaat->tempat_lahir ?? 'Tidak Diketahui' }}, {{ optional($anggota->jemaat)->tanggal_lahir ? \Carbon\Carbon::parse($anggota->jemaat->tanggal_lahir)->translatedFormat('d F Y') :'-' }}</td>
                        <td class="text-center">{{ optional($anggota->jemaat)->tanggal_baptis ? \Carbon\Carbon::parse($anggota->jemaat->tanggal_baptis)->translatedFormat('d F Y'):'-' }}</td>
                        <td class="text-center">{{ optional($anggota->jemaat)->tanggal_sidi ? \Carbon\Carbon::parse($anggota->jemaat->tanggal_sidi)->translatedFormat('d F Y'):'-' }}</td>
                        <td class="text-center">{{ $anggota->jemaat->asal_gereja ?? 'Tidak Diketahui' }}</td>
                        <td class="text-center">{{ optional($anggota->jemaat)->tanggal_terdaftar ? \Carbon\Carbon::parse($anggota->jemaat->tanggal_terdaftar)->translatedFormat('d F Y') :'-'}}</td>
                        <td class="text-center">{{ $anggota->jemaat->status_aktif ?? '-' }}</td>
                        <td>{{ $anggota->jemaat->keterangan ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</body>
</html>
