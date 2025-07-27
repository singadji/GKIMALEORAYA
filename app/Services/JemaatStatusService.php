<?php

namespace App\Services;

use App\Models\Atestasi;
use App\Models\PindahGereja;
use App\Models\MeninggalDunia;

class JemaatStatusService
{
    public function handle($jemaat, $status, $tanggal = null, $gereja = null)
    {
        $tanggal = $tanggal;
        $gereja = $gereja;

        if ($status === 'Atestasi Keluar') {
            $this->upsertAtestasi($jemaat->id_jemaat, $tanggal, $gereja);
        }

        if ($status === 'Pindah Gereja') {
            $this->upsertPindahGereja($jemaat->id_jemaat, $tanggal, $gereja);
        }

        if ($status === 'Meninggal Dunia') {
            $this->upsertMeninggal($jemaat->id_jemaat, $tanggal);
        }
    }

    private function upsertAtestasi($id_jemaat, $tanggal, $gereja)
    {
        Atestasi::updateOrCreate(
            ['id_jemaat' => $id_jemaat, 'keluar' => 1],
            ['tanggal' => $tanggal, 'gereja' => $gereja, 'setuju' => 1]
        );
    }

    private function upsertPindahGereja($id_jemaat, $tanggal, $gereja)
    {
        // Pastikan tidak buat jika sudah ada Atestasi
        $alreadyAtestasi = Atestasi::where('id_jemaat', $id_jemaat)->where('keluar', 1)->exists();
        if ($alreadyAtestasi) return;

        PindahGereja::updateOrCreate(
            ['id_jemaat' => $id_jemaat, 'ke' => 1],
            ['tanggal' => $tanggal, 'gereja' => $gereja, 'setuju' => 1]
        );
    }

    private function upsertMeninggal($id_jemaat, $tanggal)
    {
        MeninggalDunia::updateOrCreate(
            ['id_jemaat' => $id_jemaat],
            ['tanggal' => $tanggal, 'alamat' => '-']
        );
    }
}
