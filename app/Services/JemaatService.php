<?php
namespace App\Services;

use App\Models\Jemaat;
use App\Models\Atestasi;
use App\Models\PindahGereja;
use App\Models\Meningal;
use App\Models\HubunganKeluarga;
use App\Models\KkJemaat;

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
            'pindahJemaat.jemaatPindah'
        ])->get();
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
}
