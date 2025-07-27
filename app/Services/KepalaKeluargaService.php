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

        $status = $request->status_aktif_kk;

        // Validasi jika status memerlukan tanggal & gereja
        if (in_array($status, ['Atestasi Keluar', 'Pindah Gereja'])) {
            if (empty($request->tanggal_pindah_kk) || empty($request->gereja_tujuan_kk)) {
                throw new \Exception("Kepala Keluarga: Tanggal dan Gereja tujuan wajib diisi untuk status '$status'.");
            }
        }

        // Update data jemaat
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
            'status_aktif'      => $status,
            'keterangan'        => $request->keterangan_kk,
        ]);

        $jemaat->save();

        return $jemaat;
    }
}

