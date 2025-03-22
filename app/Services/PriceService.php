<?php

namespace App\Services;

use App\Models\MasterKomoditas;
use App\Models\HargaPangan;
use Carbon\Carbon;

class PriceService
{
    public static function getHarga($request)
    {
        $currentMonth = Carbon::now()->format('n');
        $currentYear = Carbon::now()->format('Y');

        // Ambil data terakhir di tabel
        $lastWeekData = HargaPangan::select('tahun', 'bulan', 'minggu_ke')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->orderBy('minggu_ke', 'desc')
            ->first();

        // Jika tidak ada data, kembalikan array kosong
        if (!$lastWeekData) {
            return [];
        }

        // Tentukan data minggu ini
        $selectedYear = $lastWeekData->tahun;
        $selectedMonth = $lastWeekData->bulan;
        $selectedWeek = $lastWeekData->minggu_ke;

        // Tentukan data minggu sebelumnya
        $lastYear = $selectedYear;
        $lastMonth = $selectedMonth;
        $selectedWeekLast = $selectedWeek - 1;

        // Jika minggu ini adalah minggu pertama, pindah ke bulan sebelumnya
        if ($selectedWeek == 1) {
            $lastMonth--;
            if ($lastMonth == 0) {
                $lastMonth = 12; // Desember tahun sebelumnya
                $lastYear--;
            }

            // Ambil minggu terakhir dari bulan sebelumnya
            $selectedWeekLast = HargaPangan::where('bulan', $lastMonth)
                ->where('tahun', $lastYear)
                ->orderBy('minggu_ke', 'desc')
                ->value('minggu_ke');
        }

        // Data minggu ini
        $hargaMingguIni = HargaPangan::with('detail')
            ->where('tahun', $selectedYear)
            ->where('bulan', $selectedMonth)
            ->where('minggu_ke', $selectedWeek)
            ->get();

        // Data minggu lalu
        $hargaMingguLalu = collect(); // Default koleksi kosong
        if ($selectedWeekLast !== null) {
            $hargaMingguLalu = HargaPangan::with('detail')
                ->where('tahun', $lastYear)
                ->where('bulan', $lastMonth)
                ->where('minggu_ke', $selectedWeekLast)
                ->get();
        }

        // Komoditas
        $komoditas = MasterKomoditas::all();

        // Perhitungan harga rata-rata per komoditas
        $data = [];
        foreach ($komoditas as $kom) {
            $totalHargaMingguIni = 0;
            $totalHargaMingguLalu = 0;
            $countMingguIni = 0;
            $countMingguLalu = 0;

            foreach ($hargaMingguIni as $hm) {
                foreach ($hm->detail as $detail) {
                    if ($detail->id_komoditas == $kom->id) {
                        $totalHargaMingguIni += $detail->harga;
                        $countMingguIni++;
                    }
                }
            }

            foreach ($hargaMingguLalu as $hl) {
                foreach ($hl->detail as $detail) {
                    if ($detail->id_komoditas == $kom->id) {
                        $totalHargaMingguLalu += $detail->harga;
                        $countMingguLalu++;
                    }
                }
            }

            $rataMingguIni = $countMingguIni ? $totalHargaMingguIni / $countMingguIni : 0;
            $rataMingguLalu = $countMingguLalu ? $totalHargaMingguLalu / $countMingguLalu : 0;

            $selisih = $rataMingguIni - $rataMingguLalu;

            $status = '';
            $icon = '';
            $color = '';
            $bg = '';

            if ($rataMingguIni == $rataMingguLalu) {
                $status = "Harga stabil";
                $icon = "";
                $color = "text-primary";
                $bg = "bg-primary";
            } elseif ($rataMingguIni > $rataMingguLalu) {
                $status = "Harga naik";
                $icon = "bi bi-arrow-up-circle-fill";
                $color = "text-danger";
                $bg = "bg-danger";
            } elseif ($rataMingguIni < $rataMingguLalu) {
                $status = "Harga turun";
                $icon = "bi bi-arrow-down-circle-fill";
                $color = "text-success";
                $bg = "bg-success";
            }

            $persen = $rataMingguIni != 0 ? abs(round($selisih * 100 / $rataMingguIni, 2)) : 0;

            // Memastikan 'gambar' tersedia
            $gambar = $kom->gambar ?? 'default-image.jpg';

            $data[] = [
                'id_komoditas' => $kom->id,
                'nama_komoditas' => $kom->nama,
                'gambar' => $gambar,
                'rata_minggu_ini' => $rataMingguIni,
                'rata_minggu_lalu' => $rataMingguLalu,
                'selisih' => $selisih,
                'persen' => $persen,
                'status' => $status,
                'icon' => $icon,
                'color' => $color,
                'bg' => $bg,
            ];
        }

        return $data;
    }
}
