<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\PindahGereja;
use App\Models\Jemaat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Atestasi;
use Alert;

class PindahGerejaKeluarController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $search = $request->input('search');

        $query = DB::table('pindah_gereja as pg')
            ->join('jemaat as j', 'pg.id_jemaat', '=', 'j.id_jemaat')
            ->leftJoin('hubungan_keluarga as hk', 'hk.id_jemaat', '=', 'j.id_jemaat')
            ->leftJoin('kk_jemaat as kk_anggota', 'kk_anggota.id_kk_jemaat', '=', 'hk.id_kk_jemaat')
            ->leftJoin('kk_jemaat as kk_kk', 'kk_kk.id_jemaat', '=', 'j.id_jemaat')
            ->where('pg.dari', 1)
            ->where('pg.ke', 0);

        $queryAtestasi = DB::table('atestasi as a')
            ->join('jemaat as j', 'a.id_jemaat', '=', 'j.id_jemaat')
            ->leftJoin('hubungan_keluarga as hk', 'hk.id_jemaat', '=', 'j.id_jemaat')
            ->leftJoin('kk_jemaat as kk_anggota', 'kk_anggota.id_kk_jemaat', '=', 'hk.id_kk_jemaat')
            ->leftJoin('kk_jemaat as kk_kk', 'kk_kk.id_jemaat', '=', 'j.id_jemaat')
            ->where('a.keluar', 1)
            ->whereNull('a.deleted_at');

        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('pg.tanggal', [$tanggalAwal, $tanggalAkhir]);
            $queryAtestasi->whereBetween('a.tanggal', [$tanggalAwal, $tanggalAkhir]);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('j.nia', 'like', "%{$search}%")
                  ->orWhere('j.nama_jemaat', 'like', "%{$search}%");
            });
            $queryAtestasi->where(function ($q) use ($search) {
                $q->where('j.nia', 'like', "%{$search}%")
                  ->orWhere('j.nama_jemaat', 'like', "%{$search}%");
            });
        }

        $selectCols = [
            'j.id_jemaat', 'j.nia', 'j.nama_jemaat', 'j.gender', 'j.telepon',
            'tanggal', 'gereja', 'setuju',
            DB::raw('COALESCE(kk_kk.alamat, kk_anggota.alamat) as alamat'),
            DB::raw('COALESCE(kk_kk.id_group_wilayah, kk_anggota.id_group_wilayah) as id_group_wilayah'),
        ];

        $query->select(
            array_merge($selectCols, [
                'pg.id_pindah_gereja',
                DB::raw("'Pindah' as sumber")
            ])
        );

        $queryAtestasi->select(
            array_merge($selectCols, [
                'a.id_atestasi as id_pindah_gereja',
                DB::raw("'Atestasi Keluar' as sumber")
            ])
        );

        $query->union($queryAtestasi);

        $data = DB::table(DB::raw("({$query->toSql()}) as combined"))
            ->mergeBindings($query)
            ->orderBy('tanggal', 'desc')
            ->paginate(15)
            ->withQueryString();

        $totalAll = DB::table('pindah_gereja')->where('dari', 1)->where('ke', 0)->count()
                  + DB::table('atestasi')->where('keluar', 1)->whereNull('deleted_at')->count();
        $totalDisetujui = DB::table('pindah_gereja')->where('dari', 1)->where('ke', 0)->where('setuju', 1)->count()
                       + DB::table('atestasi')->where('keluar', 1)->where('setuju', 1)->whereNull('deleted_at')->count();
        $totalPending = DB::table('pindah_gereja')->where('dari', 1)->where('ke', 0)->where('setuju', 0)->count()
                     + DB::table('atestasi')->where('keluar', 1)->where('setuju', 0)->whereNull('deleted_at')->count();

        $title = 'Hapus Data!';
        $text = "Data akan dihapus, Anda Yakin?";
        $btn = '<a href="' . route('administrasi.pindah-gereja-keluar.create') . '" class="btn btn-info bg-gradient-info btn-sm mt-3 ms-auto">Tambah Baru</a>';
        $page = 'Administrasi';
        $judul = 'Atestasi Keluar Pindah';
        $subjudul = 'Kelola Data Atestasi Keluar Pindah Jemaat';
        $tombol = $btn;
        $Hjudul = $subjudul;

        return view('administrasi.pindah-gereja-keluar.index', compact(
            'data',
            'tanggalAwal',
            'tanggalAkhir',
            'search',
            'totalAll',
            'totalDisetujui',
            'totalPending',
            'title',
            'text',
            'page',
            'judul',
            'subjudul',
            'tombol',
            'Hjudul'
        ));
    }

    public function create()
    {
        $jemaatList = Jemaat::where('status_aktif', 'Aktif')
            ->orderBy('nama_jemaat')
            ->get(['id_jemaat', 'nia', 'nama_jemaat', 'gender']);

        $btn = '<a href="' . route('administrasi.pindah-gereja-keluar.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $title = 'Tambah Atestasi Keluar Pindah';
        $page = 'Administrasi';
        $judul = 'Atestasi Keluar Pindah';
        $subjudul = 'Tambah Atestasi Keluar Pindah';
        $tombol = $btn;

        return view('administrasi.pindah-gereja-keluar.create', compact(
            'jemaatList',
            'title',
            'page',
            'judul',
            'subjudul',
            'tombol'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jemaat' => 'required|exists:jemaat,id_jemaat',
            'tanggal' => 'required|date',
            'gereja' => 'required|string|max:255',
            'jenis' => 'required|in:pindah,atestasi_keluar',
        ]);

        if ($request->jenis === 'atestasi_keluar') {
            $atestasi = new Atestasi();
            $atestasi->id_jemaat = $request->id_jemaat;
            $atestasi->tanggal = $request->tanggal;
            $atestasi->masuk = 0;
            $atestasi->keluar = 1;
            $atestasi->gereja = $request->gereja;
            $atestasi->setuju = 0;
            $atestasi->save();

            $jemaat = Jemaat::find($request->id_jemaat);
            if ($jemaat) {
                $jemaat->status_aktif = 'Atestasi Keluar';
                $jemaat->save();
            }
        } else {
            $pindah = new PindahGereja();
            $pindah->id_jemaat = $request->id_jemaat;
            $pindah->tanggal = $request->tanggal;
            $pindah->dari = 1;
            $pindah->ke = 0;
            $pindah->gereja = $request->gereja;
            $pindah->setuju = 0;
            $pindah->save();

            $jemaat = Jemaat::find($request->id_jemaat);
            if ($jemaat) {
                $jemaat->status_aktif = 'Pindah Gereja';
                $jemaat->save();
            }
        }

        Alert::success('Berhasil', 'Data berhasil disimpan.');

        return redirect()->route('administrasi.pindah-gereja-keluar.index');
    }

    private function findRecord($id)
    {
        $pindah = PindahGereja::with('jemaatPindah.hubunganKeluarga.kkJemaat')->find($id);
        if ($pindah) {
            return ['type' => 'pindah_gereja', 'record' => $pindah];
        }

        $atestasi = Atestasi::with('jemaatAtestasi')->where('id_atestasi', $id)->first();
        if ($atestasi) {
            return ['type' => 'atestasi', 'record' => $atestasi];
        }

        return null;
    }

    public function cetak($id)
    {
        $found = $this->findRecord($id);
        if (!$found) {
            abort(404);
        }

        $title = 'Surat Atestasi Keluar Pindah';

        if ($found['type'] === 'atestasi') {
            $record = $found['record'];
            $jemaat = $record->jemaatAtestasi;
            $alamat = $jemaat?->hubunganKeluarga?->kkJemaat?->alamat ?? $jemaat?->alamat ?? '-';

            return view('administrasi.pindah-gereja-keluar.cetak', compact('title', 'record', 'found'), [
                'nama_jemaat' => $jemaat?->nama_jemaat ?? '-',
                'nia' => $jemaat?->nia ?? '-',
                'gender' => $jemaat?->gender ?? '-',
                'tempat_lahir' => $jemaat?->tempat_lahir ?? '-',
                'tanggal_lahir' => $jemaat?->tanggal_lahir,
                'alamat' => $alamat,
                'telepon' => $jemaat?->telepon ?? '-',
                'gereja' => $record->gereja ?? '-',
                'tanggal' => $record->tanggal,
                'nomor_surat' => $record->nomor_surat ?? null,
                'nama_ketua' => config('app.nama_ketua', 'Nama Ketua'),
                'nama_sekretaris' => config('app.nama_sekretaris', 'Nama Sekretaris'),
            ]);
        }

        $record = $found['record'];
        $jemaat = $record->jemaatPindah;

        return view('administrasi.pindah-gereja-keluar.cetak', compact('title', 'record', 'found'), [
            'nama_jemaat' => $jemaat?->nama_jemaat ?? '-',
            'nia' => $jemaat?->nia ?? '-',
            'gender' => $jemaat?->gender ?? '-',
            'tempat_lahir' => $jemaat?->tempat_lahir ?? '-',
            'tanggal_lahir' => $jemaat?->tanggal_lahir,
            'alamat' => $jemaat?->hubunganKeluarga?->kkJemaat?->alamat ?? $jemaat?->alamat ?? '-',
            'telepon' => $jemaat?->telepon ?? '-',
            'gereja' => $record->gereja ?? '-',
            'tanggal' => $record->tanggal,
            'nomor_surat' => $record->nomor_surat ?? null,
            'nama_ketua' => config('app.nama_ketua', 'Nama Ketua'),
            'nama_sekretaris' => config('app.nama_sekretaris', 'Nama Sekretaris'),
        ]);
    }

    public function edit($id)
    {
        $found = $this->findRecord($id);
        if (!$found) {
            abort(404);
        }

        $pindah = $found['record'];

        $jemaatList = Jemaat::orderBy('nama_jemaat')
            ->get(['id_jemaat', 'nia', 'nama_jemaat', 'gender']);

        $btn = '<a href="' . route('administrasi.pindah-gereja-keluar.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $title = 'Edit Atestasi Keluar Pindah';
        $page = 'Administrasi';
        $judul = 'Atestasi Keluar Pindah';
        $subjudul = 'Edit Atestasi Keluar Pindah';
        $tombol = $btn;

        return view('administrasi.pindah-gereja-keluar.edit', compact(
            'pindah',
            'jemaatList',
            'title',
            'page',
            'judul',
            'subjudul',
            'tombol'
        ));
    }

    public function update(Request $request, $id)
    {
        $found = $this->findRecord($id);
        if (!$found) {
            abort(404);
        }

        $request->validate([
            'id_jemaat' => 'required|exists:jemaat,id_jemaat',
            'tanggal' => 'required|date',
            'gereja' => 'required|string|max:255',
            'setuju' => 'required|in:0,1',
        ]);

        if ($found['type'] === 'atestasi') {
            $record = $found['record'];
            $record->id_jemaat = $request->id_jemaat;
            $record->tanggal = $request->tanggal;
            $record->gereja = $request->gereja;
            $record->setuju = $request->setuju;
            $record->save();
        } else {
            $record = $found['record'];
            $record->id_jemaat = $request->id_jemaat;
            $record->tanggal = $request->tanggal;
            $record->gereja = $request->gereja;
            $record->setuju = $request->setuju;
            $record->save();
        }

        Alert::success('Berhasil', 'Data atestasi keluar pindah berhasil diperbarui.');

        return redirect()->route('administrasi.pindah-gereja-keluar.index');
    }

    public function destroy($id)
    {
        $found = $this->findRecord($id);
        if (!$found) {
            abort(404);
        }

        $jemaatId = $found['record']->id_jemaat;
        $found['record']->delete();

        $otherPindah = PindahGereja::where('id_jemaat', $jemaatId)->first();
        $otherAtestasi = Atestasi::where('id_jemaat', $jemaatId)->where('keluar', 1)->first();
        if (!$otherPindah && !$otherAtestasi) {
            $jemaat = Jemaat::find($jemaatId);
            if ($jemaat) {
                $jemaat->status_aktif = 'Aktif';
                $jemaat->save();
            }
        }

        Alert::success('Berhasil', 'Data atestasi keluar pindah berhasil dihapus.');

        return redirect()->route('administrasi.pindah-gereja-keluar.index');
    }

    public function setuju($id)
    {
        $found = $this->findRecord($id);
        if (!$found) {
            abort(404);
        }

        $found['record']->setuju = 1;
        $found['record']->save();

        Alert::success('Berhasil', 'Atestasi keluar pindah telah disetujui.');

        return redirect()->back();
    }
}
