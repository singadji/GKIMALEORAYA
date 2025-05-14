<?php
namespace App\Services;

use App\Models\Jemaat;
use App\Models\Atestasi;
use App\Models\PindahGereja;
use App\Models\Meningal;
use App\Models\HubunganKeluarga;
use App\Models\KkJemaat;
use Illuminate\Support\Facades\DB;

class JemaatService
{
    public function getJemaatList()
    {
        return Jemaat::with([
            'kkJemaat',
            'hubunganKeluarga.kkJemaat',
            'atestasiJemaat',
            'atestasiJemaat.jemaatAtestasi',
            'pindahJemaat',
            'pindahJemaat.jemaatPindah',
            'meninggalJemaat.jemaatMeninggaal'
        ])->orderby('nia')->get();
    }

    public function getJemaatDetail($id)
    {
        $jemaat = Jemaat::with([
            'kkJemaat',
            'hubunganKeluarga.kkJemaat',
            'atestasiJemaat',
            'atestasiJemaat.jemaatAtestasi',
            'pindahJemaat',
            'pindahJemaat.jemaatPindah'
        ])->where('id_jemaat', $id)->firstOrFail();

        $kk = KkJemaat::where('id_jemaat', $jemaat->id_jemaat)->first();
        $kk_jemaat = KkJemaat::select('id_jemaat')->get();

        if ($kk) {
            $kepalaKeluarga = $kk;
            $id_kk = $kk->id_kk_jemaat;
        } else {
            $hubungan = HubunganKeluarga::where('id_jemaat', $id)->with('kkJemaat')->first();
            $kepalaKeluarga = $hubungan?->kkJemaat;
            $id_kk = $hubungan?->id_kk_jemaat;
        }

        $anggotaKeluarga = HubunganKeluarga::where('id_kk_jemaat', $id_kk)->with('jemaat')->get();

        return compact('jemaat', 'kepalaKeluarga', 'anggotaKeluarga', 'id_kk', 'kk_jemaat');
    }

    // di App\Services\JemaatService.php
    public function JumlahJemaat($tahunAkhir)
    {
        $Jaktif = DB::selectOne("
            SELECT COUNT(id_jemaat) AS total
            FROM jemaat
            WHERE status_aktif IN ('Aktif', 'Pasif', 'Bukan Anggota')
                AND tanggal_lahir IS NOT NULL
                AND tanggal_terdaftar IS NOT NULL
                AND tanggal_terdaftar <= STR_TO_DATE(CONCAT(?, '-12-31'), '%Y-%m-%d')
                AND tanggal_sidi IS NOT NULL
                AND tanggal_baptis IS NOT NULL
        ", [$tahunAkhir]);

        $Jatestasi = Jemaat::where('status_aktif', 'Atestasi Keluar')->count();
        $Jpasif = Jemaat::where('status_aktif', 'Pasif')->count();
        $Jkk = Jemaat::where('status_aktif', 'Aktif')->whereHas('kkJemaat')->count();

        $baptisan = Jemaat::with(['kkJemaat', 'hubunganKeluarga.kkJemaat'])
            ->whereNull('tanggal_sidi')
            ->whereNotNull('tanggal_baptis')
            ->whereIn('status_aktif', ['Bukan Anggota'])
            ->where('tanggal_lahir', '!=', '1900-01-01')
            ->where('tanggal_baptis', '!=', '1900-01-01')
            ->count();

        return [
            'total_jemaat' => $Jaktif->total,
            'atestasi_keluar' => $Jatestasi,
            'pasif' => $Jpasif,
            'jemaat_kk' => $Jkk,
            'baptisan' => $baptisan,
        ];
    }

}
