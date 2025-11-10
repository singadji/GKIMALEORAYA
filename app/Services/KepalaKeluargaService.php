<?php

namespace App\Services;

use App\Models\Jemaat;
use App\Models\KkJemaat;

class KepalaKeluargaService
{
    public function update($request)
    {
        $kk = KkJemaat::where('id_kk_jemaat', $request->id_kk)->firstOrFail();
        $jemaat = Jemaat::where('id_jemaat', $kk->id_jemaat)->firstOrFail();

        $jemaat->fill([
            'nama_jemaat'       => $request->kepala_keluarga,
            'gender'            => $request->p_l_kk,
            'telepon'           => $request->telepon_kk,
            'tempat_lahir'      => $request->tempat_lahir_kk,
            'tanggal_lahir'     => parseTanggalIndo($request->tanggal_lahir_kk),
            'tanggal_baptis'    => parseTanggalIndo($request->tanggal_baptis_kk),
            'tanggal_sidi'      => parseTanggalIndo($request->tanggal_sidi_kk),
            'tanggal_nikah'     => parseTanggalIndo($request->tanggal_nikah_kk),
            'status_menikah'    => $request->status_menikah_kk,
            'asal_gereja'       => $request->asal_gereja_kk,
            'tanggal_terdaftar' => parseTanggalIndo($request->tanggal_terdaftar_kk),
            'status_aktif'      => $request->status_aktif_kk,
            'keterangan'        => $request->keterangan_kk,
        ]);

        $jemaat->save();

        $kk->update([
            'alamat'           => $request->alamat_kk,
            'id_group_wilayah' => $request->group_wilayah_kk,
        ]);

        return $jemaat;
    }
}
