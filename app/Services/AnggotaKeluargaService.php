<?php
namespace App\Services;

use App\Models\Jemaat;
use App\Models\HubunganKeluarga;
use App\Models\KkJemaat;

class AnggotaKeluargaService
{
    public function updateAll($request, $idKK, $groupWilayah, $statusService)
    {
        $messages = [];

        if (!is_array($request->nia_anggota)) {
            return $messages;
        }

        foreach ($request->nia_anggota as $index => $nia) {
            if (!isset($request->nama_jemaat[$index])) continue;

            $status = $request->status_aktif[$index] ?? null;

            // Lanjut hanya jika status aktif anggota adalah pindah/atestasi keluar
            if (in_array($status, ['Atestasi Keluar', 'Pindah Gereja'])) {
                $tanggal = $request->tanggal_pindah[$index] ?? null;
                $gereja = $request->gereja_tujuan[$index] ?? null;

                if (!$tanggal || !$gereja) {
                    throw new \Exception("Anggota '{$request->nama_jemaat[$index]}' wajib isi tanggal & gereja tujuan untuk status '$status'.");
                }
            }

            $anggota = Jemaat::find($request->id_anggota[$index]) ?? new Jemaat();

            $anggota->fill([
                'nia'               => $nia,
                'nama_jemaat'       => $request->nama_jemaat[$index],
                'gender'            => $request->p_l[$index],
                'tempat_lahir'      => $request->tempat_lahir[$index] ?? null,
                'tanggal_lahir'     => parseTanggalIndo($request->tanggal_lahir[$index] ?? null),
                'tanggal_baptis'    => parseTanggalIndo($request->tanggal_baptis[$index] ?? null),
                'tanggal_sidi'      => parseTanggalIndo($request->tanggal_sidi[$index] ?? null),
                'asal_gereja'       => $request->asal_gereja[$index] ?? null,
                'tanggal_terdaftar' => parseTanggalIndo($request->tanggal_terdaftar[$index] ?? null),
                'status_aktif'      => $status,
                'status_menikah'    => $request->status_menikah[$index],
                'keterangan'        => $request->keterangan[$index] ?? null,
            ]);

            $anggota->save();

            // Status aktif handling (Atestasi/Pindah/Meninggal)
            $statusService->handle(
                $anggota,
                $status,
                $request->tanggal_pindah[$index] ?? null,
                $request->gereja_tujuan[$index] ?? null
            );

            HubunganKeluarga::updateOrCreate(
                ['id_jemaat' => $anggota->id_jemaat],
                [
                    'id_kk_jemaat'      => $idKK,
                    'hubungan_keluarga' => $request->hubungan_keluarga[$index] ?? '-'
                ]
            );

            // Buat KK baru untuk pria menikah
            if (
                $request->status_menikah[$index] === "Menikah" &&
                !preg_match('/[WKA]/i', $nia) &&
                $request->p_l[$index] === "L"
            ) {
                $kkBaru = KkJemaat::updateOrCreate(
                    ['id_jemaat' => $anggota->id_jemaat],
                    [
                        'id_group_wilayah' => $groupWilayah,
                        'alamat'           => '-'
                    ]
                );

                if ($kkBaru->wasRecentlyCreated) {
                    $messages[] = "NIA $nia: Status menikah, kepala keluarga baru dibuat.";
                }
            }
        }

        return $messages;
    }
}

