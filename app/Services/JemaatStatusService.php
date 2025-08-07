<?php

namespace App\Services;

use App\Models\Atestasi;
use App\Models\PindahGereja;
use App\Models\MeninggalDunia;

class JemaatStatusService
{
    public function handle($jemaat, $status, $tanggal = null, $gereja = null)
    {
        switch ($status) {
            case 'Atestasi Keluar':
                $this->handleAtestasi($jemaat, $tanggal, $gereja);
                break;

            case 'Pindah Gereja':
                $this->handlePindahGereja($jemaat, $tanggal, $gereja);
                break;

            case 'Meninggal Dunia':
                $this->handleMeninggal($jemaat, $tanggal);
                break;

            default:
                // Tidak perlu update status khusus
                break;
        }
    }

    private function handleAtestasi($jemaat, $tanggal, $gereja)
    {
        $existing = Atestasi::where('id_jemaat', $jemaat->id_jemaat)
                            ->where('keluar', 1)
                            ->first();

        if (!$existing && (!$tanggal || !$gereja)) {
            throw new \Exception("Anggota '{$jemaat->nama_jemaat}' wajib isi tanggal & gereja tujuan untuk status 'Atestasi Keluar'.");
        }

        if ($this->shouldUpdate($existing, $tanggal, $gereja)) {
            Atestasi::updateOrCreate(
                ['id_jemaat' => $jemaat->id_jemaat, 'keluar' => 1],
                ['tanggal' => $tanggal, 'gereja' => $gereja, 'setuju' => 1]
            );
        }
    }

    private function handlePindahGereja($jemaat, $tanggal, $gereja)
    {
        // Abaikan jika sudah ada Atestasi
        $isAtestasi = Atestasi::where('id_jemaat', $jemaat->id_jemaat)
                              ->where('keluar', 1)->exists();
        if ($isAtestasi) return;

        $existing = PindahGereja::where('id_jemaat', $jemaat->id_jemaat)
                                ->where('ke', 1)->first();

        if (!$existing && (!$tanggal || !$gereja)) {
            throw new \Exception("Anggota '{$jemaat->nama_jemaat}' wajib isi tanggal & gereja tujuan untuk status 'Pindah Gereja'.");
        }

        if ($this->shouldUpdate($existing, $tanggal, $gereja)) {
            PindahGereja::updateOrCreate(
                ['id_jemaat' => $jemaat->id_jemaat, 'ke' => 1],
                ['tanggal' => $tanggal, 'gereja' => $gereja, 'setuju' => 1]
            );
        }
    }

    private function handleMeninggal($jemaat, $tanggal)
    {
        $existing = MeninggalDunia::where('id_jemaat', $jemaat->id_jemaat)->first();

        if (!$existing && !$tanggal) {
            throw new \Exception("Anggota '{$jemaat->nama_jemaat}' wajib isi tanggal untuk status 'Meninggal Dunia'.");
        }

        if ($this->shouldUpdate($existing, $tanggal)) {
            MeninggalDunia::updateOrCreate(
                ['id_jemaat' => $jemaat->id_jemaat],
                ['tanggal' => $tanggal, 'alamat' => '-']
            );
        }
    }

    private function shouldUpdate($existing, $tanggal, $gereja = null)
    {
        if (!$existing) return true;

        $tanggalChanged = $tanggal && $existing->tanggal != $tanggal;
        $gerejaChanged  = $gereja && isset($existing->gereja) && $existing->gereja != $gereja;

        return $tanggalChanged || $gerejaChanged;
    }
}
