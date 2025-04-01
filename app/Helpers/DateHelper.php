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
