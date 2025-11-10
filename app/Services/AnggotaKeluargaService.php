<?php

namespace App\Services;

use App\Models\Jemaat;
use App\Models\HubunganKeluarga;
use App\Models\KkJemaat;

class AnggotaKeluargaService
{
    public function updateAll($request, $id_kk, $groupWilayah, $statusService)
    {
        $messages = [];

        if (!is_array($request->nia_anggota)) return $messages;

        foreach ($request->nia_anggota as $index => $nia) {
    // Lewati jika data penting tidak tersedia
    if (
        !isset($request->nama_jemaat[$index]) ||
        !isset($request->p_l[$index]) ||
        !isset($request->status_aktif[$index]) ||
        !isset($request->status_menikah[$index])
    ) continue;

    $jemaat = Jemaat::find($request->id_anggota[$index] ?? null) ?? new Jemaat();

    $jemaat->fill([
        'nia'               => $nia,
        'nama_jemaat'       => $request->nama_jemaat[$index],
        'gender'            => $request->p_l[$index],
        'tempat_lahir'      => $request->tempat_lahir[$index] ?? null,
        'tanggal_lahir'     => parseTanggalIndo($request->tanggal_lahir[$index] ?? null),
        'tanggal_baptis'    => parseTanggalIndo($request->tanggal_baptis[$index] ?? null),
        'tanggal_sidi'      => parseTanggalIndo($request->tanggal_sidi[$index] ?? null),
        'asal_gereja'       => $request->asal_gereja[$index] ?? null,
        'tanggal_terdaftar' => parseTanggalIndo($request->tanggal_terdaftar[$index] ?? null),
        'status_aktif'      => $request->status_aktif[$index],
        'status_menikah'    => $request->status_menikah[$index],
        'keterangan'        => $request->keterangan[$index] ?? null,
    ]);
    $jemaat->save();

    $status = $request->status_aktif[$index];
    //$tanggal = in_array($status, ['Atestasi Keluar', 'Pindah Gereja', 'Meninggal Dunia']) ? $request->tanggal_pindah[$index] ?? null : null;
    if (in_array($status, ['Atestasi Keluar', 'Pindah Gereja'])) {
        $tanggal = $request->tanggal_pindah[$index] ?? null;
    } elseif ($status === 'Meninggal Dunia') {
        $tanggal = $request->tanggal_meninggal[$index] ?? null;
    } else {
       $tanggal = null;
    }
    $gereja = in_array($status, ['Atestasi Keluar', 'Pindah Gereja']) ? $request->gereja_tujuan[$index] ?? null : null;

    $statusService->handle($jemaat, $status, $tanggal, $gereja);

    HubunganKeluarga::updateOrCreate(
        ['id_jemaat' => $jemaat->id_jemaat],
        [
            'id_kk_jemaat'      => $id_kk,
            'hubungan_keluarga' => $request->hubungan_keluarga[$index] ?? '-',
        ]
    );

    if (
        $request->status_menikah[$index] === "Menikah" &&
        !preg_match('/[WKA]/i', $nia) &&
        $request->p_l[$index] === "L"
    ) {
        $kkBaru = KkJemaat::updateOrCreate(
            ['id_jemaat' => $jemaat->id_jemaat],
            ['id_group_wilayah' => $groupWilayah, 'alamat' => '-']
        );

        if ($kkBaru->wasRecentlyCreated) {
            $messages[] = "NIA $nia: Status menikah, data kepala keluarga baru ditambahkan.";
        }
    }
}

        return $messages;
    }
}
