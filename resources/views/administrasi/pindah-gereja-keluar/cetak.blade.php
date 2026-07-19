<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - {{ $nama_jemaat }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @page { margin: 2cm; size: A4; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.6; color: #000; }
        .surat-container { max-width: 21cm; margin: 0 auto; padding: 0; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px double #000; padding-bottom: 20px; }
        .header h1 { font-size: 16pt; font-weight: bold; margin: 5px 0; text-transform: uppercase; letter-spacing: 1px; }
        .header h2 { font-size: 14pt; font-weight: bold; margin: 5px 0; text-decoration: underline; }
        .header .nomor-surat { font-size: 12pt; margin-top: 15px; }
        .alamat-gereja { font-size: 10pt; line-height: 1.4; margin-top: 10px; }
        .content { text-align: justify; margin-bottom: 30px; }
        .content p { margin-bottom: 15px; text-indent: 1.5cm; }
        .content .opening { text-indent: 0; }
        .data-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 11pt; }
        .data-table td { padding: 6px 10px; vertical-align: top; }
        .data-table td.label { width: 30%; font-weight: bold; }
        .data-table td.separator { width: 2%; }
        .data-table td.value { width: 68%; }
        .closing { margin-top: 40px; }
        .closing .place-date { text-align: right; margin-bottom: 20px; }
        .closing .signature-block { text-align: right; }
        .closing .signature-block .title { margin-bottom: 60px; }
        .closing .signature-block .name { font-weight: bold; text-decoration: underline; text-transform: uppercase; }
        .closing .signature-block .nip { font-size: 10pt; }
        .ttd-area { height: 70px; }
        .note { margin-top: 30px; padding: 15px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 5px; font-size: 10pt; }
        .note-title { font-weight: bold; text-decoration: underline; margin-bottom: 10px; }
        @media print { .no-print { display: none !important; } body { -webkit-print-color-adjust: exact; print-color-adjust: exact; } }
        .btn-print { position: fixed; top: 20px; right: 20px; z-index: 1000; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    </style>
</head>
<body>
    <div class="no-print btn-print">
        <button onclick="window.print()" class="btn btn-primary btn-lg">
            <i class="fas fa-print me-2"></i>Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" class="btn btn-secondary btn-lg ms-2">
            <i class="fas fa-times me-2"></i>Tutup
        </button>
    </div>

    <div class="surat-container">
        <div class="header">
            <div class="text-center">
                <img src="https://gkimaleo.or.id/assets/images/gkimaleologo.png" alt="Logo GKI Maleo Raya" style="height: 80px; margin-bottom: 15px;">
            </div>
            <h1>Gereja Krinten Indonesia</h1>
            <h1>Maleo Raya</h1>
            <h2>{{ $title }}</h2>
            <div class="alamat-gereja">
                Jl. Maleo Raya, Bintaro Jaya Sektor IX, Tangerang-Selatan, Banten.<br>
                Telepon/WA: +62 896 6018 3999 | Fax: +62 21 7455781<br>
                Email: gki_maleoraya@yahoo.com
            </div>
            <div class="nomor-surat">
                Nomor: <u>{{ $nomor_surat ?? '....................' }}</u> / AT-PK / {{ date('m') }} / {{ date('Y') }}
            </div>
        </div>

        <div class="content">
            <p class="opening">
                Yang bertanda tangan di bawah ini, kami pengurus Gereja Krinten Indonesia Maleo Raya,
                dengan ini menerangkan bahwa:
            </p>

            <table class="data-table">
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td class="separator">:</td>
                    <td class="value"><u>{{ $nama_jemaat }}</u></td>
                </tr>
                <tr>
                    <td class="label">NIA</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $nia }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                <tr>
                    <td class="label">Tempat / Tanggal Lahir</td>
                    <td class="separator">:</td>
                    <td class="value">
                        {{ $tempat_lahir }} /
                        {{ $tanggal_lahir ? \Carbon\Carbon::parse($tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Alamat</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $alamat }}</td>
                </tr>
                <tr>
                    <td class="label">No. Telepon / HP</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $telepon }}</td>
                </tr>
                <tr>
                    <td class="label">Gereja Tujuan</td>
                    <td class="separator">:</td>
                    <td class="value"><u>{{ $gereja }}</u></td>
                </tr>
                <tr>
                    <td class="label">Tanggal Pindah</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $tanggal ? \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') : '-' }}</td>
                </tr>
            </table>

            <p>
                Jemaat tersebut di atas telah memindahkan keanggotaannya dari Gereja Krinten Indonesia Maleo Raya
                ke <strong>{{ $gereja }}</strong>, dan telah dikeluarkan surat atestasi keluar pindah
                pada tanggal <strong>{{ $tanggal ? \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') : '..............' }}</strong>.
            </p>
            <p>
                Selama menjadi jemaat di GKI Maleo Raya, beliau/ia telah beribadah dan melayani dengan setia.
                Kami berdoa agar di tempat baru, jemaat tersebut terus diberkati Tuhan dan setia dalam melayani-Nya.
            </p>
            <p>
                Surat keterangan ini diberikan untuk digunakan sebagaimana mestinya.
            </p>
        </div>

        <div class="closing">
            <div class="place-date">
                Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </div>
            <div class="signature-block">
                <div class="title">
                    Ketua Dewan Gereja<br>
                    GKI Maleo Raya
                </div>
                <div class="ttd-area"></div>
                <div class="name">{{ config('app.ketua_geraja', 'Nama Ketua Dewan Gereja') }}</div>
                <div class="nip">NIA: {{ config('app.ketua_nia', '..........') }}</div>
            </div>
        </div>

        <div class="note">
            <div class="note-title"><i class="fas fa-info-circle me-1"></i> CATATAN PENTING:</div>
            <ol style="margin: 0; padding-left: 20px; line-height: 1.8;">
                <li>Surat ini dibuat dalam rangkap 2 (dua), masing-masing bermaterai cukup.</li>
                <li>Surat ini berlaku selama 6 (enam) bulan terhitung sejak tanggal terbit.</li>
                <li>Setiap pengubahan atau pencoretisan pada surat ini mengakibatkan surat menjadi tidak sah.</li>
                <li>Jemaat dimohon untuk segera melaporkan ke gereja tujuan yang bersangkutan.</li>
            </ol>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') { e.preventDefault(); window.print(); }
        });
    </script>
</body>
</html>
