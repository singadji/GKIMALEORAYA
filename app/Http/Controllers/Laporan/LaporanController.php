<?php
namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Imports\JemaatImport;

use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Jemaat;
use App\Models\KkJemaat;
use App\Models\HubunganKeluarga;
use App\Models\Atestasi;
use App\Models\PindahGereja;
use App\Models\MeninggalDunia;
use App\Services\JemaatService;
use App\ViewModels\JemaatViewModel;
use App\ViewModels\JemaatDetailViewModel;
use App\Services\JemaatStatusService;
use App\Services\KepalaKeluargaService;
use App\Services\AnggotaKeluargaService;

use Carbon\Carbon;


use Alert;

class LaporanController extends Controller
{
    protected $jemaatService;
    protected $jemaatStatusService;
    protected $kepalaKeluargaService;
    protected $anggotaKeluargaService;

    public function __construct(
        JemaatService $jemaatService,
        JemaatStatusService $jemaatStatusService,
        KepalaKeluargaService $kepalaKeluargaService,
        AnggotaKeluargaService $anggotaKeluargaService
    ) {
        $this->jemaatService = $jemaatService;
        $this->jemaatStatusService = $jemaatStatusService;
        $this->kepalaKeluargaService = $kepalaKeluargaService;
        $this->anggotaKeluargaService = $anggotaKeluargaService;
    }

    public function detail(Request $request, $detail)
    {
        switch ($detail) {
            case 'jemaat-wilayah':
                return $this->laporanJemaatWilayah($request);
            case 'atestasi-masuk':
                return $this->laporanAtestasiMasuk($request);
            case 'atestasi-keluar':
                return $this->laporanAtestasiKeluar($request);
            case 'meninggal':
                return $this->laporanMeninggal($request);
            case 'jemaat-tanggal-terdaftar':
                return $this->laporanJemaatPeriode($request);
            case 'jemaat-tanggal-lahir':
                return $this->laporanJemaatTanggalLahir($request);
            default:
                abort(404, 'Laporan tidak ditemukan.');
        }
    }

    public function laporanAtestasiKeluar(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        // Standard Query Pattern: CTE with ROW_NUMBER for distinct jemaat
        $tahunAkhir = $tanggalAkhir ?? (date('Y') . '-12-31');
        $tahunAwal = $tanggalAwal ?? '0001-01-01';

        $sql = "
            WITH ranked AS (
                SELECT
                    j.id_jemaat,
                    j.nama_jemaat,
                    j.nia,
                    j.gender,
                    a.tanggal,
                    a.gereja,
                    j.telepon,
                    j.keterangan,
                    COALESCE(kk_kk.alamat, kk_anggota.alamat) as alamat,
                    COALESCE(kk_kk.id_group_wilayah, kk_anggota.id_group_wilayah) as id_group_wilayah,
                    ROW_NUMBER() OVER (PARTITION BY j.id_jemaat ORDER BY a.tanggal DESC) as rn
                FROM atestasi a
                JOIN jemaat j ON a.id_jemaat = j.id_jemaat
                LEFT JOIN hubungan_keluarga hk ON hk.id_jemaat = j.id_jemaat
                LEFT JOIN kk_jemaat kk_anggota ON kk_anggota.id_kk_jemaat = hk.id_kk_jemaat
                LEFT JOIN kk_jemaat kk_kk ON kk_kk.id_jemaat = j.id_jemaat
                WHERE a.keluar = 1
                AND a.tanggal BETWEEN '$tahunAwal' AND '$tahunAkhir'
            )
            SELECT * FROM ranked WHERE rn = 1
            ORDER BY tanggal DESC
        ";

        $data = collect(DB::select($sql));

        $title  = 'Hapus Data!';
        $text   = "Data akan dihapus, Anda Yakin?";
        $btn    = '';
        $page   = 'Administrasi';
        $judul  = 'Data Jemaat Atestasi Keluar';
        $subjudul = 'Data Jemaat Atestasi Keluar' . ($tanggalAwal && $tanggalAkhir ? " Periode " . Carbon::parse($tanggalAwal)->translatedFormat('d F Y') . " - " . Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') : " (Semua Data)");
        $tombol = $btn;
        $Hjudul = $subjudul;

        return view('laporan.atestasi-keluar', compact('data', 'btn', 'page', 'judul', 'subjudul', 'tombol', 'Hjudul', 'tanggalAwal', 'tanggalAkhir'));
    }

    public function laporanAtestasiMasuk(Request $request)
        {
            $tanggalAwal = $request->input('tanggal_awal');
            $tanggalAkhir = $request->input('tanggal_akhir');

            // Default: 3 bulan terakhir
            $tigaBulanLalu = Carbon::now()->subMonths(3)->startOfDay();

            $query = Jemaat::where('status_aktif', 'Aktif')
                ->orderBy('tanggal_terdaftar', 'desc');

            if ($tanggalAwal && $tanggalAkhir) {
                $query->whereBetween('tanggal_terdaftar', [$tanggalAwal, $tanggalAkhir]);
            } else {
                $query->where('tanggal_terdaftar', '>=', $tigaBulanLalu);
            }

            $data = $query->get();

            $title  = 'Hapus Data!';
            $text   = "Data akan dihapus, Anda Yakin?";
            $btn    = '';
            $page   = 'Administrasi';
            $judul  = 'Data Jemaat Atestasi Masuk';
            $subjudul = 'Data Jemaat Atestasi Masuk' . ($tanggalAwal && $tanggalAkhir ? " Periode " . Carbon::parse($tanggalAwal)->translatedFormat('d F Y') . " - " . Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') : " dalam 3 bulan terakhir");
            $tombol = $btn;
            $Hjudul = $subjudul;

            return view('laporan.atestasi-masuk', compact('data', 'btn', 'page', 'judul', 'subjudul', 'tombol', 'Hjudul', 'tanggalAwal', 'tanggalAkhir'));
        }

    public function laporanMeninggal(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        // Default: 3 bulan terakhir
        $tigaBulanLalu = Carbon::now()->subMonths(3)->startOfDay();

        $query = MeninggalDunia::with(['jemaat.hubunganKeluarga.kkJemaat'])
            ->orderBy('tanggal', 'desc');

        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
        } else {
            $query->where('tanggal', '>=', $tigaBulanLalu);
        }

        $data = $query->get();

        $totalMeniggal = $data->count();
        $totalLaki = $data->where('jemaat.gender', 'L')->count();
        $totalPerempuan = $data->where('jemaat.gender', 'P')->count();

        $btn    = '';
        $page   = 'Administrasi';
        $judul  = 'Data Jemaat Meninggal';
        $subjudul = 'Data Jemaat Meninggal' . ($tanggalAwal && $tanggalAkhir ? " Periode " . Carbon::parse($tanggalAwal)->translatedFormat('d F Y') . " - " . Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') : " dalam 3 bulan terakhir");
        $tombol = $btn;
        $Hjudul = ($subjudul);

        return view('laporan.meninggal', compact('data', 'btn', 'page', 'judul', 'subjudul', 'tombol', 'Hjudul', 'tanggalAwal', 'tanggalAkhir', 'totalMeniggal', 'totalLaki', 'totalPerempuan'));
    }

    public function laporanJemaatWilayah(Request $request, $wilayahId = null)
    {
        $wilayah = KkJemaat::select('id_group_wilayah')
            ->distinct()
            ->orderBy('id_group_wilayah')
            ->get();

        $data = collect();

        if ($wilayahId) {
            // Ambil semua id_jemaat yang tergabung di wilayah ini
            // Meliputi: kepala keluarga (langsung di kk_jemaat) + anggota keluarga (melalui hubungan_keluarga)
            $data = DB::table('jemaat as j')
                ->join('hubungan_keluarga as hk', 'hk.id_jemaat', '=', 'j.id_jemaat')
                ->join('kk_jemaat as kk', 'kk.id_kk_jemaat', '=', 'hk.id_kk_jemaat')
                ->where('kk.id_group_wilayah', $wilayahId)
                ->where('j.status_aktif', 'Aktif')
                ->select(
                    'j.id_jemaat',
                    'j.nia',
                    'j.nama_jemaat',
                    'j.gender',
                    'j.tanggal_lahir',
                    'j.tanggal_baptis',
                    'j.tanggal_sidi',
                    'j.tanggal_terdaftar',
                    'j.status_menikah',
                    'kk.alamat',
                    'kk.id_group_wilayah'
                )
                ->orderBy('j.nama_jemaat', 'asc')
                ->groupBy('j.id_jemaat')
                ->get();
        }

        $page = 'Laporan';
        $judul = 'Data Jemaat Berdasarkan Wilayah';
        $subjudul = 'Daftar Jemaat per Wilayah Pelayanan';
        $Hjudul = $subjudul;
        $tombol = '';

        return view('laporan.jemaat-wilayah', compact(
            'data', 'page', 'judul', 'subjudul', 'Hjudul', 'tombol', 'wilayah', 'wilayahId'
        ));
    }

    public function laporanJemaatPeriode(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $query = Jemaat::with(['hubunganKeluarga.kkJemaat'])
            ->whereIn('status_aktif', ['Aktif', 'Pasif'])
            ->orderBy('tanggal_terdaftar', 'asc');

        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('tanggal_terdaftar', [$tanggalAwal, $tanggalAkhir]);
        }

        $data = $query->get();

        $page = 'Laporan';
        $judul = 'Data Jemaat Berdasarkan Periode';
        $subjudul = 'Daftar Jemaat Berdasarkan Rentang Tanggal Terdaftar' . ($tanggalAwal && $tanggalAkhir ? " Periode " . Carbon::parse($tanggalAwal)->translatedFormat('d F Y') . " - " . Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') : '');
        $Hjudul = $subjudul;
        $tombol = '';

        return view('laporan.jemaat-periode', compact(
            'data', 'page', 'judul', 'subjudul', 'Hjudul', 'tombol', 'tanggalAwal', 'tanggalAkhir'
        ));
    }

   public function laporanJemaatTanggalLahir(Request $request)
{
    $bulanAwal  = $request->input('bulan_awal');
    $hariAwal   = $request->input('hari_awal');
    $bulanAkhir = $request->input('bulan_akhir');
    $hariAkhir  = $request->input('hari_akhir');

    // Default: semua data aktif dengan tanggal lahir
    $query = DB::table('jemaat as j')
        ->leftJoin('hubungan_keluarga as hk', 'hk.id_jemaat', '=', 'j.id_jemaat')
        ->leftJoin('kk_jemaat as kk', 'kk.id_kk_jemaat', '=', 'hk.id_kk_jemaat')
        ->select(
                'j.id_jemaat',
                'j.nia',
                'j.nama_jemaat',
                'j.gender',
                'j.tanggal_lahir',
                'j.tanggal_terdaftar',
                'kk.alamat',
                'j.telepon',
                'j.keterangan',
                'hk.id_kk_jemaat',
                'kk.id_group_wilayah'
            )
        ->whereNotNull('j.tanggal_lahir')
        ->whereIn('j.status_aktif', ['Aktif', 'Bukan Anggota', 'Pasif'])
        ->orderByRaw("DATE_FORMAT(j.tanggal_lahir, '%m-%d') ASC");

    if ($bulanAwal && $hariAwal && $bulanAkhir && $hariAkhir) {
        $awal  = sprintf('%02d-%02d', $bulanAwal, $hariAwal);
        $akhir = sprintf('%02d-%02d', $bulanAkhir, $hariAkhir);

        if ($awal <= $akhir) {
            $query->whereRaw(
                "DATE_FORMAT(j.tanggal_lahir, '%m-%d') BETWEEN ? AND ?",
                [$awal, $akhir]
            );
        } else {
            $query->where(function ($q) use ($awal, $akhir) {
                $q->whereRaw("DATE_FORMAT(j.tanggal_lahir, '%m-%d') >= ?", [$awal])
                  ->orWhereRaw("DATE_FORMAT(j.tanggal_lahir, '%m-%d') <= ?", [$akhir]);
            });
        }
    }

    $data = $query->get();

    $page     = 'Laporan';
    $judul    = 'Data Jemaat Berdasarkan Rentang Tanggal Lahir';
    $subjudul = 'Daftar Jemaat Berdasarkan Rentang Tanggal Lahir';
    $Hjudul = $subjudul;
    $tombol = '';

    return view('laporan.jemaat-tanggal-lahir', compact(
        'data', 'page', 'judul', 'subjudul', 'Hjudul', 'tombol',
        'bulanAwal', 'hariAwal', 'bulanAkhir', 'hariAkhir'
    ));
}

}