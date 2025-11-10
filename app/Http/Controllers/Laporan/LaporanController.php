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
            case 'atestasi-masuk':
                return $this->laporanAtestasiMasuk($request);
            case 'atestasi-keluar':
                return $this->laporanAtestasiKeluar($request);
            case 'meninggal':
                return $this->laporanMeninggal($request);
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
}
