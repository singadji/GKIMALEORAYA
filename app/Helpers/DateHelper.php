<?php
    if (!function_exists('tanggalIndo')) {
        function tanggalIndo($tanggal) {
            $bulan = [
                "January" => "Januari", "February" => "Februari", "March" => "Maret",
                "April" => "April", "May" => "Mei", "June" => "Juni",
                "July" => "Juli", "August" => "Agustus", "September" => "September",
                "October" => "Oktober", "November" => "November", "December" => "Desember"
            ];
            $formatInggris = date("d F Y", strtotime($tanggal));
            return strtr($formatInggris, $bulan);
        }
    }

    function parseTanggalIndo($tanggal) {
        $bulan = [
            'Januari' => '01',
            'Februari' => '02',
            'Maret' => '03',
            'April' => '04',
            'Mei' => '05',
            'Juni' => '06',
            'Juli' => '07',
            'Agustus' => '08',
            'September' => '09',
            'Oktober' => '10',
            'November' => '11',
            'Desember' => '12',
        ];
    
        $parts = explode(' ', $tanggal); // misalnya: ['01', 'Januari', '2020']
        if (count($parts) !== 3) return null;
    
        $day = $parts[0];
        $month = $bulan[$parts[1]] ?? '01';
        $year = $parts[2];
    
        return "$year-$month-$day"; // 2020-01-01
    }
    