<?php

namespace App\Imports;

use App\Models\Jemaat;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class JemaatImport
{
    public function import($file)
{
    $path = $file->getRealPath();
    $data = \Maatwebsite\Excel\Facades\Excel::toArray([], $file, null, \Maatwebsite\Excel\Excel::XLSX);

    $rows = $data[0];

    $requiredHeaders = [
        'NIA', 'NAMA JEMAAT', 'GENDER', 'TELEPON', 'ALAMAT', 'ASAL GEREJA', 'TANGGAL TERDAFTAR',
        'WILAYAH', 'TEMPAT LAHIR', 'TANGGAL LAHIR', 'TANGGAL BAPTIS', 'TANGGAL SIDI',
        'STATUS PERNIKAHAN', 'TANGGAL PERNIKAHAN', 'STATUS ANGGOTA', 'KETERANGAN',
        'KEPALA KELUARGA', 'HUBUNGAN KELUARGA'
    ];

    $headers = array_slice($rows[0], 0, count($requiredHeaders));

    if (array_diff($requiredHeaders, $headers)) {
        throw new \Exception('Format file tidak valid.');
    }

    // Hilangkan header dari array
    $dataRows = array_slice($rows, 1);

    // Proses per 100 baris
    $chunks = array_chunk($dataRows, 100);

    foreach ($chunks as $chunkIndex => $chunkRows) {
        DB::beginTransaction();
        try {
            foreach ($chunkRows as $rowIndex => $row) {
                $nia = trim((string) $row[0]);
                if (empty($nia)) continue;

                $this->saveOrUpdateJemaat($nia, $row);
                $idJemaat = DB::table('jemaat')->where('nia', $nia)->value('id_jemaat');

                $this->handleKeluarga($row, $idJemaat);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Gagal pada baris ke-" . ($chunkIndex + 1) . ": " . $e->getMessage());
        }
    }

    return 'Data jemaat berhasil diunggah.';
}

    private function saveOrUpdateJemaat($nia, $row)
    {
        $tanggalTerdaftar = $this->convertExcelDate($row[6]);
        $asalGereja = trim($row[5]);

        DB::table('jemaat')->updateOrInsert(
            ['nia' => $nia],
            [
                'nama_jemaat'       => $row[1],
                'gender'            => $row[2],
                'telepon'           => $row[3] ?? null,
                'asal_gereja'       => $asalGereja,
                'tanggal_terdaftar' => $tanggalTerdaftar,
                'tempat_lahir'      => $row[8],
                'tanggal_lahir'     => $this->convertExcelDate($row[9]),
                'tanggal_baptis'    => $this->convertExcelDate($row[10]),
                'tanggal_sidi'      => $this->convertExcelDate($row[11]),
                'tanggal_nikah'     => $this->convertExcelDate($row[13]),
                'status_aktif'      => $row[14],
                'status_menikah'    => $row[12],
                'keterangan'        => $row[15],
                'updated_at'        => now(),
                'created_at'        => now(),
            ]
        );

        $idJemaat = DB::table('jemaat')->where('nia', $nia)->value('id_jemaat');

        if ($tanggalTerdaftar) {
            $sudahAtestasi = DB::table('atestasi')
                ->where('id_jemaat', $idJemaat)
                ->where('masuk', 1)
                ->exists();
        
            $sudahPindah = DB::table('pindah_gereja')
                ->where('id_jemaat', $idJemaat)
                ->where('dari', 1)
                ->exists();
        
            if ($asalGereja && !$sudahAtestasi) {
                // Atestasi Masuk
                DB::table('atestasi')->insert([
                    'id_jemaat' => $idJemaat,
                    'tanggal'   => $tanggalTerdaftar,
                    'masuk'     => 1,
                    'setuju'    => 1,
                    'gereja'    => $row[5],
                    'created_at'=> now(),
                    'updated_at'=> now(),
                ]);
            } elseif (!$asalGereja && !$sudahAtestasi && !$sudahPindah) {
                // Pindah Gereja Masuk (hanya jika belum masuk di atestasi & belum ada data pindah)
                DB::table('pindah_gereja')->insert([
                    'id_jemaat' => $idJemaat,
                    'tanggal'   => $tanggalTerdaftar,
                    'dari'      => 1,
                    'setuju'    => 1,
                    'gereja'    => $row[5],
                    'created_at'=> now(),
                    'updated_at'=> now(),
                ]);
            }
        }

        if(trim($row[14]) === 'Atestasi Keluar')
        {
            DB::table('atestasi')->Insert(
                ['id_jemaat' => $idJemaat,
                    'tanggal'   => now(),
                    'keluar'    => 1,
                    'setuju'    => 1,
                    'created_at'=> now(),
                    'updated_at'=> now(),
                ]);
        }

        if(trim($row[14]) === 'Tidak Aktif' && trim($row[15]) === 'Meninggal Dunia')
        {
            DB::table('meninggal_dunia')->updateOrInsert(
                ['id_jemaat' => $idJemaat],
                [
                    'tanggal'   => now(),
                    'alamat'    => '',
                    'created_at'=> now(),
                    'updated_at'=> now(),
                ]);
        }
    }


    private function handleKeluarga($row, $idJemaat)
    {
        $wilayah = trim($row[7]);
        $idGroupWilayah = $this->getIdGroupWilayah($wilayah);
        $kepalaKeluargaCol = strtolower(trim($row[17]));

        if($kepalaKeluargaCol === 'kk') {
            // Jemaat ini adalah kepala keluarga
            DB::table('kk_jemaat')->updateOrInsert(
                ['id_jemaat' => $idJemaat],
                [
                    'id_group_wilayah' => $row[7] ?? '',
                    'alamat'           => $row[4] ?? '',
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]
            );
        } else {
            // Jemaat ini anggota keluarga
            $niaKepala = trim($row[16]);
            if (!$niaKepala) return;

            // Pastikan kepala keluarga ada
            $idKepala = DB::table('jemaat')->where('nia', $niaKepala)->value('id_jemaat');
            if (!$idKepala) return;

            $idKk = DB::table('kk_jemaat')->where('id_jemaat', $idKepala)->value('id_kk_jemaat');
            if (!$idKk) {
                $idKk = DB::table('kk_jemaat')->insertGetId([
                    'id_jemaat'        => $idKepala,
                    'id_group_wilayah' => $row[7] ?? '',
                    'alamat'           => '',
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }

            $hubungan = isset($row[17]) && !empty(trim($row[17])) ? trim($row[17]) : 'Tidak Diketahui';

            // Insert tanpa overwrite agar bisa multi-relasi
            //if($kepalaKeluargaCol != 'KK')
            //{
                $existing = DB::table('hubungan_keluarga')
                    ->where('id_jemaat', $idJemaat)
                    ->where('id_kk_jemaat', $idKk)
                    ->exists();

                if (!$existing) {
                    DB::table('hubungan_keluarga')->insert([
                        'id_jemaat'         => $idJemaat,
                        'id_kk_jemaat'      => $idKk,
                        'hubungan_keluarga' => $hubungan,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);
                }
            //}
        }
    }

   private function convertExcelDate($excelDate)
    {
        if (is_numeric($excelDate)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate)->format('Y-m-d');
        }

        // Jika kosong atau string kosong, kembalikan tanggal default
        if (empty($excelDate)) {
            return NULL;
        }

        try {
            // Coba parse string tanggal biasa
            return \Carbon\Carbon::parse($excelDate)->format('Y-m-d');
        } catch (\Exception $e) {
            return NULL; // fallback jika parsing gagal
        }
    }

    private function getIdGroupWilayah($wilayah)
    {
        $data = DB::table('group_wilayah')->where('nama_group_wilayah', $wilayah)->first();
        return $data ? $data->id_group_wilayah : 1;
    }
}
