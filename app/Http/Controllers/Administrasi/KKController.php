<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KKJemaat;

class KKController extends Controller
{
    public function destroy($id)
    {
        try {
            // Cari data KK berdasarkan id_kk_jemaat
            $kk = DB::table('kk_jemaat')->where('id_kk_jemaat', $id)->first();

            if (!$kk) {
                return redirect()
                    ->route('administrasi.data-jemaat.index')
                    ->with('error', 'Data kepala keluarga tidak ditemukan.');
            }

            // Cek apakah ada anggota keluarga terkait di hubungan_keluarga
            $jumlahTerkait = DB::table('hubungan_keluarga')
                ->where('id_kk_jemaat', $id)
                ->count();

            if ($jumlahTerkait > 0) {
                return redirect()
                    ->route('administrasi.data-jemaat.index')
                    ->with('error', 'Tidak bisa dihapus karena masih ada anggota keluarga terkait.');
            }

            // Hapus data kk_jemaat
            DB::table('kk_jemaat')->where('id_kk_jemaat', $id)->delete();

            return redirect()
                ->route('administrasi.data-jemaat.index')
                ->with('success', 'Data kepala keluarga berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->route('administrasi.data-jemaat.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function createFromJemaat()
    {
        $id = request()->route('id');
        $jemaat = DB::table('jemaat')->where('id_jemaat', $id)->first();

        if (!$jemaat) {
            return redirect()
                ->route('administrasi.data-jemaat.index')
                ->with('error', 'Data jemaat tidak ditemukan.');
        }

        // Cek apakah jemaat sudah menjadi kepala keluarga
        $isKepalaKeluarga = DB::table('kk_jemaat')
            ->where('id_jemaat', $id)
            ->exists();

        if ($isKepalaKeluarga) {
            return redirect()
                ->route('administrasi.data-jemaat.index')
                ->with('error', 'Jemaat ini sudah menjadi kepala keluarga.');
        }

        // Buat KK baru untuk jemaat ini
        $kkJemaat = new KKJemaat();
        $kkJemaat->id_jemaat = $id;
        $kkJemaat->id_group_wilayah = 0;
        $kkJemaat->save();

        return redirect()
            ->route('administrasi.data-jemaat.index')
            ->with('success', 'Kepala keluarga berhasil dibuat untuk jemaat ini.');
    }

}
