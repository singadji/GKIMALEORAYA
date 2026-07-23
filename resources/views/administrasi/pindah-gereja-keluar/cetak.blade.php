<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Atestasi - {{ $nama_jemaat ?? '' }}</title>
    <style>
        @page { margin: 2cm; size: A4; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .surat-container {
            max-width: 21cm;
            margin: 0 auto;
            padding: 2cm;
        }
        .place-date {
            text-align: right;
            margin-bottom: 30px;
        }
        .recipient {
            margin-bottom: 30px;
            line-height: 1.5;
        }
        .recipient .title-line {
            margin-bottom: 2px;
        }
        .letter-title {
            text-align: center;
            margin: 30px 0 5px 0;
        }
        .letter-title h2 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 5px 0;
            text-decoration: underline;
        }
        .letter-number {
            text-align: center;
            font-size: 12pt;
            margin-bottom: 30px;
        }
        .salutation {
            margin-bottom: 20px;
        }
        .body-text {
            text-align: justify;
            margin-bottom: 15px;
            line-height: 1.6;
        }
        .closing-text {
            text-align: left;
            margin-bottom: 25px;
        }
        .signature-area {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            page-break-inside: avoid;
        }
        .sig-block {
            width: 45%;
            text-align: center;
        }
        .sig-title {
            margin-bottom: 80px;
            line-height: 1.4;
        }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            font-size: 11pt;
        }
        .tembusan {
            margin-top: 40px;
            font-size: 11pt;
            border-top: 1px solid #000;
            padding-top: 10px;
        }
        .tembusan-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .tembusan ol {
            margin: 0;
            padding-left: 20px;
            line-height: 1.6;
        }
        .no-print { display: block; }
        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="no-print btn-print">
        <button onclick="window.print()" style="background:#007bff;color:#fff;border:none;padding:10px 20px;border-radius:6px;cursor:pointer;font-size:14px;">
            Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" style="background:#6c757d;color:#fff;border:none;padding:10px 20px;border-radius:6px;cursor:pointer;font-size:14px;margin-left:8px;">
            Tutup
        </button>
    </div>

    <div class="surat-container">
        <div class="place-date">
            Tangerang Selatan, {{ $tanggal ? \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') : \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>

        <div class="recipient">
            <div class="title-line">Yang terhormat,</div>
            <div class="title-line" style="font-weight:bold;">Majelis Jemaat {{ $gereja ?? '...' }}</div>
            @if(!empty($gereja_alamat))
                <div class="title-line">{{ $gereja_alamat }}</div>
            @endif
        </div>

        <div class="letter-title">
            <h2>SURAT ATESTASI</h2>
        </div>
        <div class="letter-number">
            No: <u>{{ $nomor_surat ?? '...' }}</u>
        </div>

        <div class="salutation">
            Salam dalam kasih Tuhan Yesus Kristus,
        </div>

        <div class="body-text">
            Berdasarkan permohonan {{ $gender === 'P' ? 'Sdri.' : 'Sdr.' }} {{ $nama_jemaat ?? '...' }}
            NA.{{ $nia ?? '...' }} (fotocopy surat permohonan terlampir),
            maka dengan ini kami Majelis Jemaat GKI Maleo Raya
            menyerahkan keanggotaan beliau ke dalam pelayanan
            Majelis Jemaat {{ $gereja ?? '...' }}.
        </div>

        <div class="closing-text">
            Atas perhatian dan pelayanan Saudara kami ucapkan terima kasih.
        </div>

        <div class="signature-area">
            <div class="sig-block">
                <div class="sig-title">
                    Teriring salam dan doa,<br>
                    Majelis Jemaat<br>
                    GKI Maleo Raya – Tangerang
                </div>
                <div class="sig-name">Pnt. {{ $nama_ketua ?? '...' }}</div>
                <div style="font-size:10pt;">Ketua</div>
            </div>
            <div class="sig-block">
                <div class="sig-title">
                    &nbsp;<br>
                    &nbsp;<br>
                    &nbsp;
                </div>
                <div class="sig-name">Pnt. {{ $nama_sekretaris ?? '...' }}</div>
                <div style="font-size:10pt;">Sekretaris</div>
            </div>
        </div>

        <div class="tembusan">
            <div class="tembusan-title">Tembusan:</div>
            <ol>
                <li>{{ $nama_jemaat ?? '...' }}</li>
                <li>Arsip.</li>
            </ol>
        </div>
    </div>

    <script>
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') { e.preventDefault(); window.print(); }
        });
    </script>
</body>
</html>
