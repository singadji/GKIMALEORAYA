<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\Atestasi;
use App\Models\Jemaat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Alert;

class AtestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
        {
            $tab = $request->get('tab', 'keluar'); // 'masuk' or 'keluar'
            $tanggalAwal = $request->input('tanggal_awal');
            $tanggalAkhir = $request->input('tanggal_akhir');
            $search = $request->input('search');

            // Standard Query Pattern: Distinct Jemaat with latest atestasi record
            // Using subquery to get latest atestasi per jemaat
            $latestAtestasiSub = DB::table('atestasi')
            ->select('id_jemaat', DB::raw('MAX(tanggal) as latest_tanggal'))
            ->where(function ($q) use ($tab) {
                if ($tab === 'masuk') {
                    $q->where('masuk', 1);
                } else {
                    $q->where('keluar', 1);
                }
            })
            ->groupBy('id_jemaat');

        // Main query: distinct jemaat with atestasi details
                $query = DB::table('atestasi as a')
                    ->join('jemaat as j', 'a.id_jemaat', '=', 'j.id_jemaat')
                    ->joinSub($latestAtestasiSub, 'latest', function ($join) {
                        $join->on('a.id_jemaat', '=', 'latest.id_jemaat')
                             ->on('a.tanggal', '=', 'latest.latest_tanggal');
                    })
                    ->leftJoin('hubungan_keluarga as hk', 'hk.id_jemaat', '=', 'j.id_jemaat')
                    ->leftJoin('kk_jemaat as kk_anggota', 'kk_anggota.id_kk_jemaat', '=', 'hk.id_kk_jemaat')
                    ->leftJoin('kk_jemaat as kk_kk', 'kk_kk.id_jemaat', '=', 'j.id_jemaat')
                    ->where(function ($q) use ($tab) {
                        if ($tab === 'masuk') {
                            $q->where('a.masuk', 1);
                        } else {
                            $q->where('a.keluar', 1);
                        }
                    })
                    ->select(
                        'j.id_jemaat',
                        'j.nia',
                        'j.nama_jemaat',
                        'j.gender',
                        'j.telepon',
                        'j.keterangan',
                        'a.tanggal',
                        'a.gereja',
                        'a.id_atestasi',
                        DB::raw('COALESCE(kk_kk.alamat, kk_anggota.alamat) as alamat'),
                        DB::raw('COALESCE(kk_kk.id_group_wilayah, kk_anggota.id_group_wilayah) as id_group_wilayah')
                    )
                    ->distinct('j.id_jemaat')
                    ->orderBy('a.tanggal', 'desc');

        // Date filtering - only apply if user provides dates
                if ($tanggalAwal && $tanggalAkhir) {
                    $query->whereBetween('a.tanggal', [$tanggalAwal, $tanggalAkhir]);
                }

        // Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('j.nia', 'like', "%{$search}%")
                  ->orWhere('j.nama_jemaat', 'like', "%{$search}%");
            });
        }

        $atestasi = $query->paginate(15)->withQueryString();

        // Statistics - use distinct jemaat count (no date filter)
                $totalMasuk = DB::table('atestasi')
                    ->where('masuk', 1)
                    ->join('jemaat', 'atestasi.id_jemaat', '=', 'jemaat.id_jemaat')
                    ->distinct('jemaat.id_jemaat')
                    ->count();

                $totalKeluar = DB::table('atestasi')
                    ->where('keluar', 1)
                    ->join('jemaat', 'atestasi.id_jemaat', '=', 'jemaat.id_jemaat')
                    ->distinct('jemaat.id_jemaat')
                    ->count();

        $title = 'Hapus Data!';
        $text = "Data akan dihapus, Anda Yakin?";
        $btn = '';
        $page = 'Administrasi';
        $judul = 'Data Atestasi';
        $subjudul = 'Kelola Data Atestasi Masuk & Keluar';
        $tombol = $btn;
        $Hjudul = $subjudul;

        return view('administrasi.atestasi.index', compact(
            'atestasi',
            'tab',
            'tanggalAwal',
            'tanggalAkhir',
            'search',
            'totalMasuk',
            'totalKeluar',
            'btn',
            'page',
            'judul',
            'subjudul',
            'tombol',
            'Hjudul',
            'title',
            'text'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->get('type', 'keluar'); // 'masuk' or 'keluar'
        $jemaatList = Jemaat::where('status_aktif', '!=', 'Meninggal')
            ->orderBy('nama_jemaat')
            ->get(['id_jemaat', 'nia', 'nama_jemaat', 'gender']);

        $title = 'Tambah Data Atestasi';
        $page = 'Administrasi';
        $subjudul = $type === 'masuk' ? 'Tambah Atestasi Masuk' : 'Tambah Atestasi Keluar';

        return view('administrasi.atestasi.create', compact(
            'type',
            'jemaatList',
            'title',
            'page',
            'subjudul'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = $request->input('type', 'keluar');

        $request->validate([
            'id_jemaat' => 'required|exists:jemaat,id_jemaat',
            'tanggal' => 'required|date',
            'gereja' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $atestasi = new Atestasi();
        $atestasi->id_jemaat = $request->id_jemaat;
        $atestasi->tanggal = $request->tanggal;
        $atestasi->gereja = $request->gereja;
        $atestasi->keterangan = $request->keterangan;

        if ($type === 'masuk') {
            $atestasi->masuk = 1;
            $atestasi->keluar = 0;
            
            // Update jemaat status
            $jemaat = Jemaat::find($request->id_jemaat);
            if ($jemaat) {
                $jemaat->status_aktif = 'Aktif';
                $jemaat->asal_gereja = $request->gereja;
                $jemaat->tanggal_terdaftar = $request->tanggal;
                $jemaat->save();
            }
        } else {
            $atestasi->masuk = 0;
            $atestasi->keluar = 1;
            
            // Update jemaat status
            $jemaat = Jemaat::find($request->id_jemaat);
            if ($jemaat) {
                $jemaat->status_aktif = 'Atestasi Keluar';
                $jemaat->save();
            }
        }

        $atestasi->save();

        Alert::success('Berhasil', 'Data atestasi berhasil disimpan.');

        return redirect()->route('administrasi.atestasi.index', ['tab' => $type]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Atestasi $atestasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Atestasi $atestasi)
    {
        $type = $atestasi->masuk ? 'masuk' : 'keluar';
        $jemaatList = Jemaat::where('status_aktif', '!=', 'Meninggal')
            ->orderBy('nama_jemaat')
            ->get(['id_jemaat', 'nia', 'nama_jemaat', 'gender']);

        $title = 'Edit Data Atestasi';
        $page = 'Administrasi';
        $subjudul = $type === 'masuk' ? 'Edit Atestasi Masuk' : 'Edit Atestasi Keluar';

        return view('administrasi.atestasi.edit', compact(
            'atestasi',
            'type',
            'jemaatList',
            'title',
            'page',
            'subjudul'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Atestasi $atestasi)
    {
        $type = $atestasi->masuk ? 'masuk' : 'keluar';

        $request->validate([
            'id_jemaat' => 'required|exists:jemaat,id_jemaat',
            'tanggal' => 'required|date',
            'gereja' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $oldJemaatId = $atestasi->id_jemaat;
        $oldType = $type;

        $atestasi->id_jemaat = $request->id_jemaat;
        $atestasi->tanggal = $request->tanggal;
        $atestasi->gereja = $request->gereja;
        $atestasi->keterangan = $request->keterangan;
        $atestasi->save();

        // Update jemaat status if jemaat changed
        if ($oldJemaatId != $request->id_jemaat) {
            // Reset old jemaat status if needed
            $oldJemaat = Jemaat::find($oldJemaatId);
            if ($oldJemaat) {
                // Check if old jemaat has other atestasi records
                $otherAtestasi = Atestasi::where('id_jemaat', $oldJemaatId)
                    ->where('id_atestasi', '!=', $atestasi->id_atestasi)
                    ->first();
                
                if (!$otherAtestasi) {
                    if ($oldType === 'keluar') {
                        $oldJemaat->status_aktif = 'Aktif';
                    } else {
                        $oldJemaat->status_aktif = 'Aktif';
                        $oldJemaat->asal_gereja = null;
                    }
                    $oldJemaat->save();
                }
            }

            // Update new jemaat status
            $newJemaat = Jemaat::find($request->id_jemaat);
            if ($newJemaat) {
                if ($type === 'masuk') {
                    $newJemaat->status_aktif = 'Aktif';
                    $newJemaat->asal_gereja = $request->gereja;
                    $newJemaat->tanggal_terdaftar = $request->tanggal;
                } else {
                    $newJemaat->status_aktif = 'Atestasi Keluar';
                }
                $newJemaat->save();
            }
        }

        Alert::success('Berhasil', 'Data atestasi berhasil diperbarui.');

        return redirect()->route('administrasi.atestasi.index', ['tab' => $type]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Atestasi $atestasi)
    {
        $type = $atestasi->masuk ? 'masuk' : 'keluar';
        $jemaatId = $atestasi->id_jemaat;

        $atestasi->delete();

        // Check if jemaat has other atestasi records
        $otherAtestasi = Atestasi::where('id_jemaat', $jemaatId)->first();
        if (!$otherAtestasi) {
            $jemaat = Jemaat::find($jemaatId);
            if ($jemaat) {
                if ($type === 'keluar') {
                    $jemaat->status_aktif = 'Aktif';
                } else {
                    $jemaat->status_aktif = 'Aktif';
                    $jemaat->asal_gereja = null;
                }
                $jemaat->save();
            }
        }

        Alert::success('Berhasil', 'Data atestasi berhasil dihapus.');

        return redirect()->route('administrasi.atestasi.index', ['tab' => $type]);
    }

    /**
     * Print atestasi certificate
     */
    public function cetak($id, $type)
    {
        $atestasi = Atestasi::with('jemaatAtestasi.hubunganKeluarga.kkJemaat')->findOrFail($id);
        
        $title = $type === 'masuk' ? 'Surat Atestasi Masuk' : 'Surat Atestasi Keluar';
        
        return view('administrasi.atestasi.cetak', compact('atestasi', 'type', 'title'));
    }
}