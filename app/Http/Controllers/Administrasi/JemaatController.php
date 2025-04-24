<?php

namespace App\Http\Controllers\Administrasi;

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
use App\Services\JemaatService;
use App\ViewModels\JemaatViewModel;
use App\ViewModels\JemaatDetailViewModel;


use Carbon\Carbon;
use App\Halpers\DateHelper;

use Alert;


class JemaatController extends Controller
{
    protected $jemaatService;

    public function __construct(JemaatService $jemaatService)
    {
        $this->jemaatService = $jemaatService;
    }

    public function index()
    {
        $btn    = '<a href="#" class="btn btn-warning bg-gradient-warning btn-sm mt-3 ms-auto dropdown" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Upload Excel</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                        <a class="dropdown-item" href="'. route('download.template.excel.import', ['filename' => 'Template_Data_Jemaat.xlsx']) .'">Download Template</a>
                        <form action="'.route('administrasi.data-jemaat.import').'" method="POST" enctype="multipart/form-data" id="formImport">
                            '. csrf_field() .'
                            <input type="file" name="file" id="file" class="form-control" style="display: none;" accept=".xlsx,.xls" required>
                            <a href="#" class="dropdown-item" id="importLink">Upload</a>
                        </form>
                    </div>
                    <a href="' . route('administrasi.data-jemaat.create') . '" class="btn btn-info bg-gradient-info btn-sm mt-3 ms-auto">Jemaat Baru</a>';
        $page   = 'Administrasi';
        $judul  = 'Data Jemaat';
        $subjudul = 'Administrasi Jemaat';
        $tombol = $btn; 

        $jemaatList = $this->jemaatService->getJemaatList();
        $viewModel = new JemaatViewModel($jemaatList);
        $jemaatList = $viewModel->formatted();

        return view('administrasi.jemaat.index',compact('jemaatList', 'btn', 'page', 'judul', 'subjudul', 'tombol'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $btn    = '<a href="' .route('administrasi.data-jemaat.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Content Management';
        $judul  = 'Jemaat';
        $subjudul = 'Jemaat Baru';
        $tombol = $btn;
        $aksi = '' .route('administrasi.data-jemaat.store').'';

        $kk = KKJemaat::with('jemaatKK')->get();

        return view('administrasi.jemaat.form', compact(
            'btn',
            'page',
            'judul',
            'subjudul',
            'tombol', 
            'aksi',
            'kk',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction(); // Mulai transaksi

        try {
            $kk = new KkJemaat();
            //$kk = KkJemaat::where('id_kk_jemaat', $request->id_kk)->firstOrFail();
            
            // Simpan data kepala keluarga
            $KKjemaat = new Jemaat();
            $KKjemaat->nia            =   $request->nia_kk;
            $KKjemaat->nama_jemaat    =   $request->kepala_keluarga;
            $KKjemaat->gender         =   $request->p_l_kk;
            $KKjemaat->telepon        =   $request->telepon_kk;
            $KKjemaat->tempat_lahir   =   $request->tempat_lahir_kk;
            $KKjemaat->tanggal_lahir  =   $request->tanggal_lahir_kk;
            $KKjemaat->tanggal_baptis =   $request->tanggal_baptis_kk;
            $KKjemaat->tanggal_sidi   =   $request->tanggal_sidi_kk;
            $KKjemaat->tanggal_nikah  =   $request->tanggal_nikah_kk;
            $KKjemaat->status_menikah =   $request->status_menikah_kk;
            $KKjemaat->asal_gereja    =   $request->asal_gereja_kk;
            $KKjemaat->tanggal_terdaftar = $request->tanggal_terdaftar_kk;
            $KKjemaat->status_aktif   =   $request->status_aktif_kk;
            $KKjemaat->keterangan     =   $request->keterangan_kk;
            $KKjemaat->save();

            $idJemaat = $KKjemaat->id_jemaat; 

            $kk->id_jemaat = $idJemaat;
            $kk->alamat = $request->alamat;    
            $kk->id_group_wilayah = $request->group_wilayah_kk;
            $kk->save();

            if ($request->has('nia_anggota')) {
                foreach ($request->nia_anggota as $index => $nia) {
                    $anggota = Jemaat::where('nia', $nia)->first();

                    if (!$anggota) {
                        $anggota = new Jemaat();
                    }

                    $anggota->nia = $nia;
                    $anggota->nama_jemaat = $request->nama_jemaat[$index];
                    $anggota->gender = $request->p_l[$index];
                    $anggota->tempat_lahir = $request->tempat_lahir[$index];
                    $anggota->tanggal_lahir = $request->tanggal_lahir[$index];
                    $anggota->tanggal_baptis = $request->tanggal_baptis[$index];
                    $anggota->tanggal_sidi = $request->tanggal_sidi[$index];
                    $anggota->asal_gereja = $request->asal_gereja[$index];
                    $anggota->tanggal_terdaftar = $request->tanggal_terdaftar[$index];
                    $anggota->status_aktif = $request->status_aktif[$index];
                    $anggota->keterangan = $request->keterangan[$index];

                    $anggota->save();
                    $idJemaat = $anggota->id_jemaat; // ID yang baru dibuat oleh database

                    // Simpan hubungan keluarga
                    HubunganKeluarga::updateOrCreate(
                        [
                            'id_jemaat' => $idJemaat, // ID Jemaat yang baru dibuat
                        ],
                        [
                            'id_kk_jemaat' => $request->id_kk, // Kepala keluarga
                            'hubungan_keluarga' => $request->hubungan_keluarga[$index]
                        ]
                    );
                }
            }

            DB::commit();
            return redirect()->route('administrasi.data-jemaat.index')->with('success', 'Berhasil menambahkan data-jemaat.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Tampilkan error ke dalam session flash message
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('administrasi.data-jemaat.index')->with('success', 'Berhasil menambahkan data-jemaat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id, JemaatService $service)
    {
        $btn    = '<a href="' . route('administrasi.data-jemaat.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        
        confirmDelete('Hapus Data!', 'Data akan dihapus, Anda Yakin?');

        $aksi = '' .route('administrasi.data-jemaat.update', $id).'';
        
        $data = $service->getJemaatDetail($id);
        $viewModel = new JemaatDetailViewModel(...$data);

        return view('administrasi.jemaat.detail', [
            'page' => 'Administrasi',
            'judul' => 'Data Jemaat',
            'subjudul' => 'Administrasi Jemaat',
            'btn' => $viewModel->backButton(),
            'tombol' => $viewModel->backButton(),
            'aksi' => $viewModel->aksiUrl(),
            'jemaat' => $viewModel->jemaat,
            'kepalaKeluarga' => $viewModel->kepalaKeluarga,
            'anggotaKeluarga' => $viewModel->anggotaKeluarga,
            'id_kk' => $viewModel->id_kk,
            'kk_jemaat' => $viewModel->kk_jemaat,
            'id' => $id
        ]);
    }
    

    public function edit($Jemaat)
    {
        //
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $statusMessages = [];

        try {
            $kk = KkJemaat::where('id_kk_jemaat', $request->id_kk)->firstOrFail();
            
            // Simpan data kepala keluarga
            $KKjemaat = Jemaat::where('id_jemaat', $id)->firstOrFail();
            $KKjemaat->nama_jemaat       = $request->kepala_keluarga;
            $KKjemaat->gender            = $request->p_l_kk;
            $KKjemaat->telepon           = $request->telepon_kk;
            $KKjemaat->tempat_lahir      = $request->tempat_lahir_kk;
            $KKjemaat->tanggal_lahir     = parseTanggalIndo($request->tanggal_lahir_kk);
            $KKjemaat->tanggal_baptis    = parseTanggalIndo($request->tanggal_baptis_kk);
            $KKjemaat->tanggal_sidi      = parseTanggalIndo($request->tanggal_sidi_kk);
            $KKjemaat->tanggal_nikah     = parseTanggalIndo($request->tanggal_nikah_kk);
            $KKjemaat->status_menikah    = $request->status_menikah_kk;
            $KKjemaat->asal_gereja       = $request->asal_gereja_kk;
            $KKjemaat->tanggal_terdaftar = parseTanggalIndo($request->tanggal_terdaftar_kk);
            $KKjemaat->status_aktif      = $request->status_aktif_kk;
            $KKjemaat->keterangan        = $request->keterangan_kk;
            
            $KKjemaat->save();

            //atastasi keluar
            if ($request->status_aktif_kk === 'Atestasi Keluar') {
                $ates = new Atestasi();
                $ates->id_jemaat = $KKjemaat->id_jemaat;
                $ates->tanggal   = now();
                $ates->keluar    = 1;
                $ates->gereja    = $request->keterangan_kk;
                $ates->setuju    = 1;
                $ates->save();
            }

            //pindah gereja
            if ($request->status_aktif_kk === 'Pindah Gereja') {
                $pindah = new PindahGereja();
                $pindah->id_jemaat = $KKjemaat->id_jemaat;
                $pindah->tanggal   = now();
                $pindah->ke        = 1;
                $pindah->gereja    = $request->keterangan_kk;
                $pindah->setuju    = 1;
                $pindah->save();
            }

    

            // Update Anggota Keluarga
            if ($request->has('id_anggota')) {
                foreach ($request->nia_anggota as $index => $nia) {
                    $idAnggota = $request->id_anggota[$index] ?? null;
                    if ($idAnggota) {
                        $anggota = Jemaat::find($idAnggota);
                    } else {
                        $anggota = new Jemaat();
                    }
                
                    $anggota->nia               = $nia;
                    $anggota->nama_jemaat       = $request->nama_jemaat[$index];
                    $anggota->gender            = $request->p_l[$index];
                    $anggota->tempat_lahir      = $request->tempat_lahir[$index];
                    $anggota->tanggal_lahir     = parseTanggalIndo($request->tanggal_lahir[$index]);
                    $anggota->tanggal_baptis    = parseTanggalIndo($request->tanggal_baptis[$index]);
                    $anggota->tanggal_sidi      = parseTanggalIndo($request->tanggal_sidi[$index]);
                    $anggota->asal_gereja       = $request->asal_gereja[$index];
                    $anggota->tanggal_terdaftar = parseTanggalIndo($request->tanggal_terdaftar[$index]);
                    $anggota->status_aktif      = $request->status_aktif[$index];
                    $anggota->status_menikah    = $request->status_menikah[$index];
                    $anggota->keterangan        = $request->keterangan[$index];
                
                    $anggota->save();

                    if ($request->status_aktif[$index] === 'Atestasi Keluar') {
                        Atestasi::create([
                            'id_jemaat' => $anggota->id_jemaat,
                            'tanggal_keluar' => now(),
                            'asal_gereja' => $request->asal_gereja[$index],
                            'setuju' => 'Ya',
                            'masuk' => 1
                        ]);
                    }

                    $idJemaat = $anggota->id_jemaat;
                
                    HubunganKeluarga::updateOrCreate(
                        ['id_jemaat' => $idJemaat],
                        [
                            'id_kk_jemaat' => $request->id_kk,
                            'hubungan_keluarga' => $request->hubungan_keluarga[$index]
                        ]
                    );

                    if ($request->status_menikah[$index] == "Menikah" && !preg_match('/[WKA]/i', $nia) && $request->p_l[$index] == "L"){
                        $kkBaru = KkJemaat::updateOrCreate(
                            ['id_jemaat' => $idJemaat],
                            [
                                'id_group_wilayah' => $request->group_wilayah_kk,
                                'alamat' => '-'
                            ]
                        );
    
                        if ($kkBaru->wasRecentlyCreated) {
                            $statusMessages[] = "NIA $nia: Status menikah, data kepala keluarga baru ditambahkan.";
                            $idKepalaKeluargaBaru = $idJemaat;
                        }
                    }
                }                
            }
            
            $kk->alamat = $request->alamat_kk;
            $kk->id_group_wilayah = $request->group_wilayah_kk;
            $kk->save();

            if ($request->status_menikah_kk === "Belum Menikah") {
                $KKjemaatKK = KkJemaat::where('id_jemaat', $id)->first();
                if ($KKjemaatKK) {
                    $KKjemaatKK->delete();
                }
            }

            DB::commit(); 
            $successMessage = 'Data berhasil diupdate!';
            if (!empty($statusMessages)) {
                $successMessage .= '<br>' . implode('<br>', $statusMessages);
            }

            if (isset($idKepalaKeluargaBaru)) {
                return redirect('./administrasi/data-jemaat/' . $idKepalaKeluargaBaru)->with('success', $successMessage);
            } else {
                return redirect()->back()->with('success', $successMessage);
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Tampilkan error ke dalam session flash message
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $hubungan = HubunganKeluarga::where('id_jemaat', $id)->first();
            if ($hubungan) {
                $hubungan->delete();
            }
            $Jemaat = Jemaat::where('id_jemaat', $id)->firstOrFail();
            $Jemaat->delete();

            if (request()->ajax()) {
                return response()->json(['success' => 'Jemaat berhasil dihapus.']);
            }

            return redirect()->back()->with(['success' => 'Jemaat berhasil dihapus.']);

        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        // Validasi file upload
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            // Proses impor menggunakan layanan HargaBapokImport
            $importer = new JemaatImport();
            $message = $importer->import($request->file('file'));

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimport data, ' .  $e->getMessage(), 500);

        }
    }

    public function cetakJemaat($id)
    {
        $jemaat = Jemaat::with(['kkJemaat', 'hubunganKeluarga'])->where('id_jemaat', $id)->firstOrFail();

        // Cek apakah jemaat adalah kepala keluarga atau anggota keluarga
        $kk = KkJemaat::where('id_jemaat', $jemaat->id_jemaat)->first();
        $kk_jemaat = KkJemaat::select('id_jemaat')->get();

        
        if ($kk) {
            // Jemaat adalah kepala keluarga
            $kepalaKeluarga = $kk;
            $id_kk = $kk->id_kk_jemaat;
        } else {
            // Jemaat adalah anggota keluarga
            $hubungan = HubunganKeluarga::where('id_jemaat', $id)->with('kkJemaat')->first();
            $kepalaKeluarga = $hubungan?->kkJemaat;
            $id_kk = $hubungan?->id_kk_jemaat;
        }

        // Ambil semua anggota keluarga be  rdasarkan ID KK
        $anggotaKeluarga = HubunganKeluarga::where('id_kk_jemaat', $id_kk)->with('jemaat')->get();
        
        $pdf = Pdf::loadView('administrasi.jemaat.cetak', compact('jemaat', 'kepalaKeluarga', 'anggotaKeluarga', 'kk_jemaat'));
        
        return $pdf->setPaper('a4', 'landscape')->download('Data-Jemaat-'.$jemaat->nama_jemaat.'.pdf');

    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        $results = Jemaat::where('nama_jemaat', 'like', '%' . $keyword . '%')
            //->limit(10)
            ->get();

        return response()->json($results);
    }

    public function simpan(Request $request)
    {
        $kk = KkJemaat::where('id_jemaat', $request->id_kk_jemaat)->firstOrFail();
        $kkW = KkJemaat::where('id_jemaat', $request->id_jemaat)->firstOrFail();

        if($kkW){
            $kkW = KkJemaat::where('id_jemaat', $request->id_jemaat)->firstOrFail();
            $kkW->delete();
        }

        $cek = HubunganKeluarga::where('id_jemaat', $request->id_jemaat)
            ->where('id_kk_jemaat', $request->id_kk_jemaat)
            ->first();

        if ($cek) {
            return response()->json(['message' => 'Data sudah ada'], 409);
        }
        
        $anggota = new HubunganKeluarga();
        $anggota->id_kk_jemaat = $kk->id_kk_jemaat;
        $anggota->id_jemaat = $request->id_jemaat;
        $anggota->hubungan_keluarga = 'Tidak Diketahui';
        $anggota->save();

        return redirect()->back()->with('success', 'Anggota keluarga berhasil ditambah.');
    }
   
}