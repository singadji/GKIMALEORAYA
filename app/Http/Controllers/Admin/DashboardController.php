<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Identitas;
use App\Models\Jemaat;
use App\Models\KKJemaat;
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

        if($detail == 'atestasi')
        {
            $item = Jemaat::where('status_aktif', 'Atestasi Keluar')
                ->where('tanggal_terdaftar', '<=', $tahunAkhir)
                ->whereHas('atestasiJemaatKeluar')
                ->with('atestasiJemaatKeluar')
                ->get();
            $Hjudul = "<h1>Data Jemaat Atestasi</h1><hr>";
        }
        if($detail == 'aktif')
        {
            $Hjudul = "<h1>Data Jemaat Aktif</h1><hr>";
        $tahunAkhir = date('Y') . '-12-31';
            $item = Jemaat::where('status_aktif', 'Aktif')
                ->where('tanggal_terdaftar', '<=', $tahunAkhir)
                ->whereNotNull('tanggal_terdaftar')
                ->whereNotNull('tanggal_sidi')
                ->whereNotNull('tanggal_baptis')
                ->get();
        }
        if($detail == 'kepala-keluarga')
        {
            $Hjudul = "<h1>Data Kepala Keluarga</h1><hr>";
            $item = Jemaat::where('status_aktif', 'Aktif')->whereHas('kkJemaat')->where('tanggal_terdaftar', '<=', $tahunAkhir)->get();
        }

        $Hjudul = strtoupper($Hjudul);

        $jJ = $jemaatService->JumlahJemaat($tahunAkhir);

        return view('admin.dashboard.dashboard', compact('item', 'Hjudul', 'jJ', 'detail'));
    }
}
