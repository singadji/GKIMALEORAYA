<?php
namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Requests\JemaatRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Imports\JemaatImport;

use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Jemaat;
use App\Models\KKJemaat;
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
use App\Halpers\DateHelper;

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
        $tigaBulanLalu = Carbon::now()->subMonths(3)->startOfDay();

        $data = DB::table('atestasi')
            ->join('jemaat', 'atestasi.id_jemaat', '=', 'jemaat.id_jemaat')
            ->leftJoin('kk_jemaat', 'kk_jemaat.id_jemaat', '=', 'jemaat.id_jemaat')
            ->where('jemaat.status_aktif', 'Atestasi Keluar')
            ->where('atestasi.keluar', 1)
            ->where('atestasi.tanggal', '>=', $tigaBulanLalu)
            ->select(
                'jemaat.id_jemaat',
                'jemaat.nama_jemaat',
                'jemaat.nia',
                'jemaat.gender',
                'atestasi.tanggal',
                'atestasi.gereja',
                'jemaat.telepon',
                'jemaat.keterangan',
                'kk_jemaat.alamat'
            )
            ->orderBy('atestasi.tanggal', 'desc')
            ->get();

        $title  = 'Hapus Data!';
        $text   = "Data akan dihapus, Anda Yakin?";
        $btn    = '';
        $page   = 'Administrasi';
        $judul  = 'Data Jemaat Atestasi Keluar';
        $subjudul = 'Data Jemaat Atestasi Keluar dalam 3 bulan terakhir';
        $tombol = $btn; 
        $Hjudul = ($subjudul);

        return view('laporan.atestasi-keluar', compact('data', 'btn', 'page', 'judul', 'subjudul', 'tombol', 'Hjudul'));
    }

    public function laporanAtestasiMasuk(Request $request)
    {
        $tigaBulanLalu = Carbon::now()->subMonths(3)->startOfDay();

        $data = Jemaat::where('status_aktif', 'Aktif')
        ->where('tanggal_terdaftar', '>=', $tigaBulanLalu)
        ->orderBy('tanggal_terdaftar', 'desc')
        ->get();

        $title  = 'Hapus Data!';
        $text   = "Data akan dihapus, Anda Yakin?";
        $btn    = '';
        $page   = 'Administrasi';
        $judul  = 'Data Jemaat Atestasi Masuk';
        $subjudul = 'Data Jemaat Atestasi Masuk dalam 3 bulan terakhir';
        $tombol = $btn; 
        $Hjudul = ($subjudul);

        return view('laporan.atestasi-masuk', compact('data', 'btn', 'page', 'judul', 'subjudul', 'tombol', 'Hjudul'));
    }

    public function laporanMeninggal(Request $request)
    {
        $tigaBulanLalu = Carbon::now()->subMonths(3)->startOfDay();

        $data = MeninggalDunia::with(['jemaat.hubunganKeluarga.kkJemaat'])
            ->where('tanggal', '>=', $tigaBulanLalu)
            ->orderBy('tanggal', 'desc')
            ->get();
        //dd($data);
        $btn    = '';
        $page   = 'Administrasi';
        $judul  = 'Data Jemaat Meninggal';
        $subjudul = 'Data Jemaat Meninggal dalam 3 bulan terakhir';
        $tombol = $btn; 
        $Hjudul = ($subjudul);

        return view('laporan.meninggal', compact('data', 'btn', 'page', 'judul', 'subjudul', 'tombol', 'Hjudul'));
    }

    public function laporanJemaatWilayah(Request $request, $wilayahId = null)
    {
        $wilayah = KkJemaat::select('id_group_wilayah')
            ->distinct()
            ->orderBy('id_group_wilayah')
            ->get();

        $data = collect();

        if ($wilayahId) {
            $data = DB::table('jemaat as j')
                ->join('kk_jemaat as kk', 'kk.id_jemaat', '=', 'j.id_jemaat')
                ->select('*')
                ->where('kk.id_group_wilayah', $wilayahId)
                ->where('j.status_aktif', 'Aktif')
                ->orderBy('j.nama_jemaat', 'asc')
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

        $data = collect();

        if ($tanggalAwal && $tanggalAkhir) {
            $data = DB::table('jemaat as j')
                ->leftJoin('hubungan_keluarga as hk', 'hk.id_jemaat', '=', 'j.id_jemaat')
                ->leftJoin('kk_jemaat as kk', 'kk.id_kk_jemaat', '=', 'hk.id_kk_jemaat')
                ->select('*')
                ->whereBetween('j.tanggal_terdaftar', [$tanggalAwal, $tanggalAkhir])
                ->orderBy('j.tanggal_terdaftar', 'asc')
                ->get();
        }

        $page = 'Laporan';
        $judul = 'Data Jemaat Berdasarkan Periode';
        $subjudul = 'Daftar Jemaat Berdasarkan Rentang Tanggal Terdaftar';
        $Hjudul = 'Laporan Jemaat ' . ($tanggalAwal && $tanggalAkhir ? 'Periode ' . Carbon::parse($tanggalAwal)->translatedFormat('d M Y') . ' s/d ' . Carbon::parse($tanggalAkhir)->translatedFormat('d M Y') : '');
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

    $data = collect();

    if ($bulanAwal && $hariAwal && $bulanAkhir && $hariAkhir) {

        // Format MM-DD
        $awal  = sprintf('%02d-%02d', $bulanAwal, $hariAwal);
        $akhir = sprintf('%02d-%02d', $bulanAkhir, $hariAkhir);

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
            ->where('j.status_aktif', 'Aktif');

        /*
        |--------------------------------------------------
        | Rentang NORMAL (contoh: 01-03 s/d 31-03)
        |--------------------------------------------------
        */
        if ($awal <= $akhir) {

            $query->whereRaw(
                "DATE_FORMAT(j.tanggal_lahir, '%m-%d') BETWEEN ? AND ?",
                [$awal, $akhir]
            );

        }
        /*
        |--------------------------------------------------
        | Rentang LINTAS TAHUN (contoh: 15-12 s/d 10-01)
        |--------------------------------------------------
        */
        else {

            $query->where(function ($q) use ($awal, $akhir) {
                $q->whereRaw("DATE_FORMAT(j.tanggal_lahir, '%m-%d') >= ?", [$awal])
                  ->orWhereRaw("DATE_FORMAT(j.tanggal_lahir, '%m-%d') <= ?", [$akhir]);
            });

        }

        $data = $query
            ->orderByRaw("DATE_FORMAT(j.tanggal_lahir, '%m-%d') ASC")
            ->get();
    }

    $page     = 'Laporan';
    $judul    = 'Data Jemaat Berdasarkan Rentang Tanggal Lahir';
    $subjudul = 'Daftar Jemaat Berdasarkan Rentang Tanggal Lahir';

    // Judul TANPA TAHUN
    $Hjudul = 'Laporan Jemaat ' . (
    $bulanAwal && $hariAwal && $bulanAkhir && $hariAkhir
        ? 'Tanggal Lahir '
            . Carbon::createFromDate(2000, (int)$bulanAwal, (int)$hariAwal)
                ->translatedFormat('d F')
            . ' s/d '
            . Carbon::createFromDate(2000, (int)$bulanAkhir, (int)$hariAkhir)
                ->translatedFormat('d F')
        : ''
);

    $tombol = '';

    return view('laporan.jemaat-tanggal-lahir', compact(
        'data',
        'page',
        'judul',
        'subjudul',
        'Hjudul',
        'tombol',
        'bulanAwal',
        'hariAwal',
        'bulanAkhir',
        'hariAkhir'
    ));
}

}
