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
        $tahunAkhirFormatted = $tahunAkhir . '-12-31';

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

        $jJ = $jemaatService->JumlahJemaat($tahunAkhirFormatted);

        $tahun = range($tahunAwal, $tahunAkhir);

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
            'tahun'
        ));
    } //

    public function detail($detail, JemaatService $jemaatService)
    {
        $tahunAkhir = date('Y') . '-12-31';
        $jJ = $jemaatService->JumlahJemaat($tahunAkhir);

        if($detail == 'atestasi')
        {
            // Standard Query Pattern: Distinct Jemaat with latest atestasi per jemaat
            // Uses MySQL 8 CTE with ROW_NUMBER() to deduplicate
            $sql = "
                WITH ranked AS (
                    SELECT
                        j.id_jemaat,
                        j.nia,
                        j.nama_jemaat,
                        j.gender,
                        j.telepon,
                        j.keterangan,
                        a.tanggal,
                        a.gereja,
                        a.id_atestasi,
                        COALESCE(kk_kk.alamat, kk_anggota.alamat) as alamat,
                        COALESCE(kk_kk.id_group_wilayah, kk_anggota.id_group_wilayah) as id_group_wilayah,
                        ROW_NUMBER() OVER (PARTITION BY j.id_jemaat ORDER BY a.tanggal DESC) as rn
                    FROM atestasi a
                    JOIN jemaat j ON a.id_jemaat = j.id_jemaat
                    LEFT JOIN hubungan_keluarga hk ON hk.id_jemaat = j.id_jemaat
                    LEFT JOIN kk_jemaat kk_anggota ON kk_anggota.id_kk_jemaat = hk.id_kk_jemaat
                    LEFT JOIN kk_jemaat kk_kk ON kk_kk.id_jemaat = j.id_jemaat
                    WHERE a.keluar = 1
                    AND a.tanggal <= '$tahunAkhir'
                )
                SELECT * FROM ranked WHERE rn = 1
                ORDER BY tanggal DESC
            ";

            $item = DB::select($sql);

            $totalAtestasiAll = DB::table('atestasi')
                ->where('keluar', 1)
                ->where('tanggal', '<=', $tahunAkhir)
                ->join('jemaat', 'atestasi.id_jemaat', '=', 'jemaat.id_jemaat')
                ->distinct('jemaat.id_jemaat')
                ->count();

            $Hjudul = "<h1>Data Jemaat Atestasi Keluar</h1><hr>";

            // Ambil nama wilayah
            foreach ($item as $atestasi) {
                $wilayahId = $atestasi->id_group_wilayah ?? null;
                $wilayah = $wilayahId ? \App\Models\GroupWilayah::find($wilayahId) : null;
                $atestasi->nama_wilayah = $wilayah ? $wilayah->nama_group_wilayah : '-';
            }

            $gerejaList = collect($item)->pluck('gereja')->filter()->countBy()->sortDesc()->take(5)->toArray();

            $stats = [
                'total' => count($item),
                'total_all' => $totalAtestasiAll,
                'laki_laki' => collect($item)->filter(fn($a) => ($a->gender ?? '') === 'L')->count(),
                'perempuan' => collect($item)->filter(fn($a) => ($a->gender ?? '') === 'P')->count(),
                'gereja_list' => $gerejaList,
            ];

            return view('admin.dashboard.dashboard', compact('item', 'Hjudul', 'jJ', 'detail', 'stats'));
        }

        if($detail == 'aktif')
        {
            $Hjudul = "<h1>Data Jemaat Aktif</h1><hr>";
            $item = Jemaat::where('status_aktif', 'Aktif')
                ->with('kkJemaat', 'hubunganKeluarga.kkJemaat')
                ->get();

            // Ambil nama wilayah
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
            // All active KK (jemaat aktif with KK)
            $item = Jemaat::where('status_aktif', 'Aktif')
                ->whereHas('kkJemaat')
                ->with('kkJemaat.anggotaKeluarga', 'hubunganKeluarga.kkJemaat')
                ->get();

            // Ambil nama wilayah
            $item->each(function ($jemaat) {
                $wilayahCode = optional($jemaat->kkJemaat)->id_group_wilayah;
                $jemaat->nama_wilayah = $wilayahCode ? 'Wilayah ' . $wilayahCode : '-';
            });

            $activeKkIds = $item->pluck('kkJemaat.id_kk_jemaat')->filter()->values();
            $totalAnggotaKeluarga = $activeKkIds->isEmpty()
                ? 0
                : DB::table('hubungan_keluarga')
                    ->whereIn('id_kk_jemaat', $activeKkIds)
                    ->whereNull('deleted_at')
                    ->count();

            // Problematic: null or future tanggal_terdaftar
            $problematicCount = $item->filter(function ($j) use ($tahunAkhir) {
                return is_null($j->tanggal_terdaftar) || $j->tanggal_terdaftar > $tahunAkhir;
            })->count();

            // KK stats (exclude deleted)
            $totalKkDb = DB::table('kk_jemaat')->whereNull('deleted_at')->count(); // 601
            $deletedKk = DB::table('kk_jemaat')->whereNotNull('deleted_at')->count(); // 17
            $kkWithActiveHead = DB::table('kk_jemaat')
                ->join('jemaat', 'kk_jemaat.id_jemaat', '=', 'jemaat.id_jemaat')
                ->where('jemaat.status_aktif', 'Aktif')
                ->whereNull('kk_jemaat.deleted_at')
                ->count(); // 376

            $stats = [
                'total' => $item->count(), // 376
                'laki_laki' => $item->where('gender', 'L')->count(),
                'perempuan' => $item->where('gender', 'P')->count(),
                'total_anggota' => $totalAnggotaKeluarga,
                'total_kk_db' => $totalKkDb, // 601
                'deleted_kk' => $deletedKk, // 17
                'kk_with_active_head' => $kkWithActiveHead, // 376
                'problematic' => $problematicCount, // 13
            ];

           return view('admin.dashboard.dashboard', compact('item', 'Hjudul', 'jJ', 'detail', 'stats'));
        }

        return view('admin.dashboard.dashboard', compact('jJ'));
    }
}
