<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Identitas;
use App\Models\Jemaat;
use App\Models\KKJemaat;

use Image;
use PDF;

class DashboardController extends Controller
{


    // Index
    public function index()
    {
        $Jaktif = Jemaat::where('status_aktif', 'Aktif')->count();
        $Jatestasi = Jemaat::where('status_aktif', 'Atestasi Keluar')->count();
        $Jpasif = Jemaat::where('status_aktif', 'Pasif')->count();
        $Jkk = Jemaat::where('status_aktif', 'Aktif')->whereHas('kkJemaat')->count();
        $baptisan = Jemaat::with(['kkJemaat', 'hubunganKeluarga.kkJemaat'])
               ->whereNull('tanggal_sidi')
               ->whereNotNull('tanggal_baptis')
               ->whereIn('status_aktif', ['Bukan Anggota'])
               ->where('tanggal_lahir', '!=', '1900-01-01')
               ->where('tanggal_baptis', '!=', '1900-01-01')
               ->count();

               $tahunSekarang = date('Y');
               $tahunAwal = $tahunSekarang - 5;
           
               $data = [];
               $totalPerTahun = [];
           
               for ($tahun = $tahunAwal; $tahun <= $tahunSekarang; $tahun++) {
                   $jemaat = DB::table('jemaat')
                        ->selectRaw("
                           CASE 
                               WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, tanggal_terdaftar) BETWEEN 0 AND 12  THEN 'Jumlah Anggota Berusia 0-12 thn (Anak)'
                               WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, tanggal_terdaftar) BETWEEN 13 AND 17 THEN 'Jumlah Anggota Berusia 13-17 thn (Remaja)'
                               WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, tanggal_terdaftar) BETWEEN 18 AND 29 THEN 'Jumlah Anggota Berusia 18-29 thn (Pemuda)'
                               WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, tanggal_terdaftar) BETWEEN 30 AND 40 THEN 'Jumlah Anggota Berusia 30-40 thn (Dewasa Muda)'
                               WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, tanggal_terdaftar) BETWEEN 41 AND 60 THEN 'Jumlah Anggota Berusia 41-60 thn (Dewasa)'
                               ELSE 'Jumlah Anggota Berusia 61 thn ke atas (Lansia)'
                           END AS kategori_usia,
                           COUNT(*) AS jumlah
                       ")
                        //->whereNotNull('tanggal_terdaftar')
                        //->where('tanggal_sidi', '!=', '1900-01-01')
                        //->where('status_aktif', 'Aktif')
                        //->whereYear('tanggal_terdaftar', $tahun)
                        //->groupBy('kategori_usia')
                        //->get()
                        //->keyBy('kategori_usia');
                        ->whereNotNull('tanggal_terdaftar')
                        ->whereNotNull('tanggal_sidi')
                        ->where('tanggal_sidi', '!=', '1900-01-01')
                        ->whereIn('status_aktif', ['Aktif', 'Pasif'])
                        ->whereDate('tanggal_terdaftar', '<=', "$tahun-12-31")
                        ->groupBy('kategori_usia')
                        ->get();
           
                   // Inisialisasi 0 dulu untuk semua kategori
                   $kategoriList = ['Jumlah Anggota Berusia 0-12 thn (Anak)', 
                        'Jumlah Anggota Berusia 13-17 thn (Remaja)', 
                        'Jumlah Anggota Berusia 18-29 thn (Pemuda)', 
                        'Jumlah Anggota Berusia 30-40 thn (Dewasa Muda)', 
                        'Jumlah Anggota Berusia 41-60 thn (Dewasa)', 
                        'Jumlah Anggota Berusia 61 thn ke atas (Lansia)'
                    ];
                   foreach ($kategoriList as $kategori) {
                        $jumlah = $jemaat[$kategori]->jumlah ?? 0;
                        $data[$kategori]["Data $tahun"] = $jumlah;
                        $totalPerTahun[$tahun] = ($totalPerTahun[$tahun] ?? 0) + $jumlah;
                    }
           
                   foreach ($jemaat as $item) {
                       $data[$item->kategori_usia]["Data $tahun"] = $item->jumlah;
                       $totalPerTahun[$tahun] = ($totalPerTahun[$tahun] ?? 0) + $item->jumlah;
                   }
               }

        $tahun = range($tahunAwal, $tahunSekarang);

        $totalPerTahun = [];

        foreach ($data as $kategori => $tahunData) {
            foreach ($tahun as $thn) {
                $jumlah = $tahunData["Data $thn"] ?? 0;
                $totalPerTahun[$thn] = ($totalPerTahun[$thn] ?? 0) + $jumlah;
            }
        }

        return view('admin.dashboard.dashboard', compact('Jkk', 'Jaktif', 'Jatestasi', 'baptisan', 'data', 'tahun', 'totalPerTahun', 'Jpasif'));
    }

    public function detail($detail)
    {
        if($detail == 'atestasi')
        {
            $item = Jemaat::where('status_aktif', 'Atestasi Keluar')->get();
            $Hjudul = "<h1>Data Jemaat Atestasi</h1><hr>";
        }
        if($detail == 'aktif')
        {
            $Hjudul = "<h1>Data Jemaat Aktif</h1><hr>";
            $item = Jemaat::where('status_aktif', 'Aktif')->get();
        }
        if($detail == 'kepala-keluarga')
        {
            $Hjudul = "<h1>Data Kepala Keluarga</h1><hr>";
            $item = Jemaat::where('status_aktif', 'Aktif')->whereHas('kkJemaat')->get();
        }
        
        $Jaktif = Jemaat::where('status_aktif', 'Aktif')->count();
        $Jatestasi = Jemaat::where('status_aktif', 'Atestasi Keluar')->count();
        $Jkk = Jemaat::where('status_aktif', 'Aktif')->whereHas('kkJemaat')->count();
        $baptisan = Jemaat::with(['kkJemaat', 'hubunganKeluarga.kkJemaat'])
               ->whereNull('tanggal_sidi')
               ->whereNotNull('tanggal_baptis')
               ->whereIn('status_aktif', ['Bukan Anggota'])
               ->where('tanggal_lahir', '!=', '1900-01-01')
               ->count();

        $Hjudul = strtoupper($Hjudul);

        return view('admin.dashboard.dashboard', compact('Jkk', 'Jaktif', 'Jatestasi', 'item', 'Hjudul', 'baptisan'));
    }

    public function statistikUsia()
{
    $tahunSekarang = date('Y');
    $tahunAwal = $tahunSekarang - 5;

    $data = [];

    for ($tahun = $tahunAwal; $tahun <= $tahunSekarang; $tahun++) {
        $jemaat = DB::table('jemaat')
            ->selectRaw("
                CASE 
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, DATE(CONCAT($tahun, '-12-31'))) BETWEEN 0 AND 12 THEN 'Anak'
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, DATE(CONCAT($tahun, '-12-31'))) BETWEEN 13 AND 17 THEN 'Remaja'
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, DATE(CONCAT($tahun, '-12-31'))) BETWEEN 18 AND 29 THEN 'Pemuda'
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, DATE(CONCAT($tahun, '-12-31'))) BETWEEN 30 AND 40 THEN 'Dewasa Muda'
                    WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, DATE(CONCAT($tahun, '-12-31'))) BETWEEN 41 AND 60 THEN 'Dewasa'
                    ELSE 'Lansia'
                END AS kategori_usia,
                COUNT(*) AS jumlah
            ")
            ->groupBy('kategori_usia')
            ->get();

        foreach ($jemaat as $item) {
            $data[$item->kategori_usia]["Data $tahun"] = $item->jumlah;
        }
    }

    return view('admin.dashboard.dashboard', [
        'data' => $data,
        'tahun' => range($tahunAwal, $tahunSekarang)
    ]);
}
}
