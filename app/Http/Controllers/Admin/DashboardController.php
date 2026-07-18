<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\IdentitasWeb;
use App\Models\Jemaat;
use App\Models\KkJemaat;
use App\Services\JemaatService;

use Image;
use PDF;

class DashboardController extends Controller
{

    protected $jemaatService;

    public function __construct(JemaatService $jemaatService)
    {
        $this->jemaatService = $jemaatService;
    }

    // Index
    public function index(Request $request, JemaatService $jemaatService)
    {
        $tahunAwal = $request->input('tahun_awal', now()->year - 5);
        $tahunAkhir = $request->input('tahun_akhir', now()->year);

        $laporan = DB::select('CALL laporan_keanggotaan(?, ?)', [
            $tahunAwal,
            $tahunAkhir,
        ]);

        $lapUmur = DB::select('CALL laporan_umur(?, ?)', [
            $tahunAwal,
            $tahunAkhir,
        ]);

        if (empty($lapUmur)) {
            return back()->with('message', 'Data belum ada untuk tahun yang dipilih.');
        }

        $lapGender = DB::select('SELECT * FROM temp_rekap_gender ORDER BY kategori, tahun');
        $lapStatus = DB::select('SELECT * FROM temp_rekap_status ORDER BY kategori, tahun');

        $lapUmurRaw = DB::select('SELECT * FROM temp_rekap_usia ORDER BY kategori, tahun');

        $lapUmur = collect($lapUmurRaw)->groupBy('kategori')->take(6);

        $grouped = collect($lapUmurRaw)->groupBy('kategori');

        $tahunList = range($tahunAwal, $tahunAkhir);

        $lapUmurG = [];
        foreach ($grouped as $kategori => $data) {
            $row = [];
            foreach ($tahunList as $tahun) {
                $jumlah = collect($data)->firstWhere('tahun', $tahun)->jumlah ?? 0;
                $row["Data $tahun"] = $jumlah;
            }
            $lapUmurG[$kategori] = $row;
        }

        $totalGender = [];
        foreach ($lapGender as $row) {
            $totalGender[$row->tahun] = ($totalGender[$row->tahun] ?? 0) + $row->jumlah;
        }

        $totalAll = [];
        foreach ($lapStatus as $row) {
            $totalAll[$row->tahun] = ($totalGender[$row->tahun] ?? 0) + ($row->jumlah ?? 0);
        }

        $totalTahun = [];
        foreach (array_keys($totalGender) as $tahun) {
            $totalTahun[$tahun] = $totalGender[$tahun] ?? 0;
        }


        $tahunG = []; 
        $dataG = [];
        
        foreach ($laporan as $row) {
            foreach ($row as $key => $value) {
                if ($key === 'kategori') {
                    $kategori = $value;
                    if (!isset($data[$kategori])) {
                        $dataG[$kategori] = [];
                    }
                } elseif (preg_match('/Data (\d{4})/', $key, $matches)) {
                    $thn = $matches[1];
                    $tahunG[$thn] = true;
                    $dataG[$kategori][$key] = $value;
                }
            }
        }
        
        $tahunG = array_keys($tahunG);
        sort($tahunG);
        
        $jJ = $jemaatService->JumlahJemaat($tahunAkhir);
        
        $tahun = range($tahunAwal, $tahunAkhir);

                $jemaatList = Jemaat::with(['hubunganKeluarga.kkJemaat'])->get();

                return view('admin.dashboard.dashboard', compact('jJ',
                    'laporan',
                    'tahunAwal',
                    'tahunAkhir',
                    'dataG',
                    'tahunG',
                    'lapUmur',
                    'lapUmurG',
                    'lapGender',
                    'lapStatus',
                    'totalGender',
                    'totalAll',
                    'totalTahun',
                    'tahun',
                                'jemaatList'
                            ));
    } //

    public function detail($detail, JemaatService $jemaatService)
    {
        $tahunAkhir = date('Y') . '-12-31';
        $jJ = $jemaatService->JumlahJemaat($tahunAkhir);

        if($detail == 'atestasi')
        {
            $item = Jemaat::where('status_aktif', 'Atestasi Keluar')
                ->where('tanggal_terdaftar', '<=', $tahunAkhir)
                ->whereHas('atestasiJemaatKeluar')
                ->with(['atestasiJemaatKeluar', 'kkJemaat', 'hubunganKeluarga.kkJemaat'])
                ->get();
            $Hjudul = "<h1>Data Jemaat Atestasi</h1><hr>";

            // Ambil nama wilayah
            $item->each(function ($jemaat) {
                $wilayahId = $jemaat->kkJemaat->id_group_wilayah ?? optional($jemaat->hubunganKeluarga->kkJemaat)->id_group_wilayah ?? null;
                $wilayah = $wilayahId ? \App\Models\GroupWilayah::find($wilayahId) : null;
                $jemaat->nama_wilayah = $wilayah ? $wilayah->nama_group_wilayah : '-';
            });

            // Total atestasi tanpa filter tanggal
            $totalAtestasiAll = Jemaat::where('status_aktif', 'Atestasi Keluar')
                ->whereHas('atestasiJemaatKeluar')
                ->count();

            // Gereja tujuan terbanyak
            $gerejaList = $item->pluck('atestasiJemaatKeluar.gereja')->filter()->countBy()->sortDesc()->take(5)->toArray();

            $stats = [
                'total' => $item->count(),
                'total_all' => $totalAtestasiAll,
                'laki_laki' => $item->where('gender', 'Laki-Laki')->count() ?: $item->where('gender', 'L')->count(),
                'perempuan' => $item->where('gender', 'Perempuan')->count() ?: $item->where('gender', 'P')->count(),
                'gereja_list' => $gerejaList,
            ];

            return view('admin.dashboard.dashboard', compact('item', 'Hjudul', 'jJ', 'detail', 'stats'));
        }

        if($detail == 'atestasi-masalah')
        {
            $Hjudul = "<h1>Data Atestasi - Perlu Perbaikan</h1><hr>";

            // Atestasi keluar tapi tanggal_terdaftar kosong/masa depan ATAU tanpa record atestasiJemaatKeluar
            $item = Jemaat::where('status_aktif', 'Atestasi Keluar')
                ->where(function ($query) use ($tahunAkhir) {
                    $query->whereNull('tanggal_terdaftar')
                          ->orWhere('tanggal_terdaftar', '>', $tahunAkhir);
                })
                ->whereHas('atestasiJemaatKeluar')
                ->with(['atestasiJemaatKeluar', 'kkJemaat', 'hubunganKeluarga.kkJemaat'])
                ->get();

            // Juga tampilkan yang punya atestasi tapi tidak punya record atestasiJemaatKeluar
            $itemNoRecord = Jemaat::where('status_aktif', 'Atestasi Keluar')
                ->where('tanggal_terdaftar', '<=', $tahunAkhir)
                ->whereNull('tanggal_terdaftar')
                ->doesntHave('atestasiJemaatKeluar')
                ->with(['kkJemaat', 'hubunganKeluarga.kkJemaat'])
                ->get();

            $item = $item->concat($itemNoRecord);

            $item->each(function ($jemaat) {
                $wilayahId = $jemaat->kkJemaat->id_group_wilayah ?? optional($jemaat->hubunganKeluarga->kkJemaat)->id_group_wilayah ?? null;
                $wilayah = $wilayahId ? \App\Models\GroupWilayah::find($wilayahId) : null;
                $jemaat->nama_wilayah = $wilayah ? $wilayah->nama_group_wilayah : '-';
            });

            $stats = [
                'total' => $item->count(),
                'laki_laki' => $item->where('gender', 'Laki-Laki')->count() ?: $item->where('gender', 'L')->count(),
                'perempuan' => $item->where('gender', 'Perempuan')->count() ?: $item->where('gender', 'P')->count(),
            ];

            return view('admin.dashboard.dashboard', compact('item', 'Hjudul', 'jJ', 'detail', 'stats'));
        }
        if($detail == 'aktif')
        {
            $Hjudul = "<h1>Data Jemaat Aktif</h1><hr>";
            $item = Jemaat::where('status_aktif', 'Aktif')
                ->where('tanggal_terdaftar', '<=', $tahunAkhir)
                ->whereNotNull('tanggal_terdaftar')
                ->whereNotNull('tanggal_sidi')
                ->whereNotNull('tanggal_baptis')
                ->with(['kkJemaat', 'hubunganKeluarga.kkJemaat'])
                ->get();

            // Ambil nama wilayah
            $item->each(function ($jemaat) {
                $wilayahId = $jemaat->kkJemaat->id_group_wilayah ?? optional($jemaat->hubunganKeluarga->kkJemaat)->id_group_wilayah ?? null;
                $wilayah = $wilayahId ? \App\Models\GroupWilayah::find($wilayahId) : null;
                $jemaat->nama_wilayah = $wilayah ? $wilayah->nama_group_wilayah : '-';
            });

            // Total semua jemaat dengan data lengkap (sama dengan dashboard: Aktif + Pasif + Bukan Anggota)
            $totalAktifAll = Jemaat::whereIn('status_aktif', ['Aktif', 'Pasif', 'Bukan Anggota'])
                ->where('tanggal_terdaftar', '<=', $tahunAkhir)
                ->whereNotNull('tanggal_terdaftar')
                ->whereNotNull('tanggal_sidi')
                ->whereNotNull('tanggal_baptis')
                ->whereNotNull('tanggal_lahir')
                ->count();

            // Hitung yang tanggal_lahir kosong (belumlah lengkap)
            $belumLengkap = $item->filter(function ($j) {
                return empty($j->tanggal_lahir);
            })->count();

            $stats = [
                'total' => $item->count(),
                'total_all' => $totalAktifAll,
                'laki_laki' => $item->where('gender', 'Laki-Laki')->count() ?: $item->where('gender', 'L')->count(),
                'perempuan' => $item->where('gender', 'Perempuan')->count() ?: $item->where('gender', 'P')->count(),
                'dewasa' => $item->filter(function ($j) {
                    return $j->tanggal_lahir && \Carbon\Carbon::parse($j->tanggal_lahir)->age >= 18;
                })->count(),
                'anak' => $item->filter(function ($j) {
                    return $j->tanggal_lahir && \Carbon\Carbon::parse($j->tanggal_lahir)->age < 18;
                })->count(),
            ];

            return view('admin.dashboard.dashboard', compact('item', 'Hjudul', 'jJ', 'detail', 'stats'));
        }
        if($detail == 'aktif-masalah')
        {
            $Hjudul = "<h1>Data Jemaat Aktif - Belum Lengkap (tanggal_lahir kosong)</h1><hr>";

            // Jemaat Aktif yang tanggal_lahir kosong (semua yang belum lengkap)
            $item = Jemaat::where('status_aktif', 'Aktif')
                ->where('tanggal_terdaftar', '<=', $tahunAkhir)
                ->whereNotNull('tanggal_terdaftar')
                ->whereNull('tanggal_lahir')
                ->with(['kkJemaat', 'hubunganKeluarga.kkJemaat'])
                ->get();

            $item->each(function ($jemaat) {
                $wilayahId = $jemaat->kkJemaat->id_group_wilayah ?? optional($jemaat->hubunganKeluarga->kkJemaat)->id_group_wilayah ?? null;
                $wilayah = $wilayahId ? \App\Models\GroupWilayah::find($wilayahId) : null;
                $jemaat->nama_wilayah = $wilayah ? $wilayah->nama_group_wilayah : '-';
            });

            $stats = [
                'total' => $item->count(),
                'laki_laki' => $item->where('gender', 'Laki-Laki')->count() ?: $item->where('gender', 'L')->count(),
                'perempuan' => $item->where('gender', 'Perempuan')->count() ?: $item->where('gender', 'P')->count(),
            ];

            return view('admin.dashboard.dashboard', compact('item', 'Hjudul', 'jJ', 'detail', 'stats'));
        }
        if($detail == 'kepala-keluarga')
        {
            $Hjudul = "<h1>Data Kepala Keluarga</h1><hr>";
            $item = Jemaat::where('status_aktif', 'Aktif')
                ->whereHas('kkJemaat')
                ->where('tanggal_terdaftar', '<=', $tahunAkhir)
                ->with(['kkJemaat', 'kkJemaat.anggotaKeluarga', 'hubunganKeluarga.kkJemaat'])
                ->get();

            // [ENHANCED] Hitung jumlah anggota per KK & ambil nama wilayah
            $item->each(function ($jemaat) {
                if ($jemaat->kkJemaat) {
                    $jemaat->jumlah_anggota = $jemaat->kkJemaat->anggotaKeluarga->count();
                    $wilayah = \App\Models\GroupWilayah::find($jemaat->kkJemaat->id_group_wilayah);
                    $jemaat->nama_wilayah = $wilayah ? $wilayah->nama_group_wilayah : '-';
                } else {
                    $jemaat->jumlah_anggota = 0;
                    $jemaat->nama_wilayah = '-';
                }
            });

            // [ENHANCED] Hitung total KK (tanpa filter tanggal) untuk perbandingan
            $totalKKAll = Jemaat::where('status_aktif', 'Aktif')
                ->whereHas('kkJemaat')
                ->count();

            // Summary stats
            $stats = [
                'total_kk' => $item->count(),
                'total_kk_all' => $totalKKAll,
                'laki_laki' => $item->where('gender', 'Laki-Laki')->count() ?: $item->where('gender', 'L')->count(),
                'perempuan' => $item->where('gender', 'Perempuan')->count() ?: $item->where('gender', 'P')->count(),
                'total_anggota' => $item->sum('jumlah_anggota'),
            ];

            return view('admin.dashboard.dashboard', compact('item', 'Hjudul', 'jJ', 'detail', 'stats'));
        }

        if($detail == 'kepala-keluarga-masalah')
        {
            $Hjudul = "<h1>Data Kepala Keluarga - Perlu Perbaikan tanggal_terdaftar</h1><hr>";

            // KK aktif tapi tanggal_terdaftar kosong atau di masa depan
            $item = Jemaat::where('status_aktif', 'Aktif')
                ->whereHas('kkJemaat')
                ->where(function ($query) use ($tahunAkhir) {
                    $query->whereNull('tanggal_terdaftar')
                          ->orWhere('tanggal_terdaftar', '>', $tahunAkhir);
                })
                ->with(['kkJemaat', 'kkJemaat.anggotaKeluarga', 'hubunganKeluarga.kkJemaat'])
                ->get();

            $item->each(function ($jemaat) {
                if ($jemaat->kkJemaat) {
                    $jemaat->jumlah_anggota = $jemaat->kkJemaat->anggotaKeluarga->count();
                    $wilayah = \App\Models\GroupWilayah::find($jemaat->kkJemaat->id_group_wilayah);
                    $jemaat->nama_wilayah = $wilayah ? $wilayah->nama_group_wilayah : '-';
                } else {
                    $jemaat->jumlah_anggota = 0;
                    $jemaat->nama_wilayah = '-';
                }
            });

            $stats = [
                'total_kk' => $item->count(),
                'laki_laki' => $item->where('gender', 'Laki-Laki')->count() ?: $item->where('gender', 'L')->count(),
                'perempuan' => $item->where('gender', 'Perempuan')->count() ?: $item->where('gender', 'P')->count(),
                'total_anggota' => $item->sum('jumlah_anggota'),
            ];

            return view('admin.dashboard.dashboard', compact('item', 'Hjudul', 'jJ', 'detail', 'stats'));
        }

        $Hjudul = strtoupper($Hjudul);

        return view('admin.dashboard.dashboard', compact('item', 'Hjudul', 'jJ', 'detail'));
    }
}
