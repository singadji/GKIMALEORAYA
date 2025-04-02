<?php

namespace App\Imports;

use App\Models\Jemaat;
use App\Models\KKJemaat;
use App\Models\HubunganKeluarga;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class JemaatImport
{
    public function import($file)
    {
        // Load file Excel
        $path = $file->getRealPath();
        $data = Excel::toArray([], $path, null, \Maatwebsite\Excel\Excel::XLSX);

        // Ambil data dari sheet pertama
        $rows = $data[0];

        // Validasi header file
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

        DB::beginTransaction();
        try {
            foreach (array_slice($rows, 1) as $row) {

                // Validasi NIA tidak boleh kosong
                $nia = trim((string) $row[0]);
                if (empty($nia)) {
                    continue; // Lewati baris jika NIA kosong
                }

                // Konversi tanggal jika dalam format angka
                $tanggal_terdaftar = $this->convertExcelDate($row[6]);
                $tanggal_lahir = $this->convertExcelDate($row[9]);
                $tanggal_baptis = $this->convertExcelDate($row[10]);
                $tanggal_sidi = $this->convertExcelDate($row[11]);
                $tanggal_nikah = $this->convertExcelDate($row[13]);

                // Simpan ke tabel jemaat (Insert atau Update)
                DB::table('jemaat')->updateOrInsert(
                    ['nia' => $nia],
                    [
                        'nama_jemaat'       => $row[1],
                        'gender'            => $row[2],
                        'telepon'           => $row[3] ?? null,
                        'asal_gereja'       => $row[5],
                        'tanggal_terdaftar' => $tanggal_terdaftar,
                        'tempat_lahir'      => $row[8],
                        'tanggal_lahir'     => $tanggal_lahir,
                        'tanggal_baptis'    => $tanggal_baptis,
                        'tanggal_sidi'      => $tanggal_sidi,
                        'tanggal_nikah'     => $tanggal_nikah,
                        'status_aktif'      => $row[14],
                        'status_menikah'    => $row[12],
                        'keterangan'        => $row[15],
                        'updated_at'        => now(),
                        'created_at'        => now(),
                    ]
                );

                // Ambil ID jemaat yang baru disimpan
                $idJemaat = DB::table('jemaat')->where('nia', $nia)->value('id_jemaat');

                // Tentukan `id_group_wilayah` dari kolom "WILAYAH"
                $wilayah = trim($row[7]); // Gunakan kolom "WILAYAH" yang benar
                $idGroupWilayah = $this->getIdGroupWilayah($wilayah);

                // Cek apakah jemaat adalah kepala keluarga
                $kepalaKeluarga = strtolower(trim($row[16])); // Normalisasi teks

                if ($kepalaKeluarga === 'ya') { 
                    // Jika kepala keluarga, simpan ke kk_jemaat
                    DB::table('kk_jemaat')->updateOrInsert(
                        ['id_jemaat' => $idJemaat],
                        [
                            'id_group_wilayah' => $idGroupWilayah,
                            'alamat'           => $row[4] ?? '', // Pastikan alamat tidak null
                            'created_at'       => now(),
                            'updated_at'       => now(),
                        ]
                    );
                } else {
                    // Jika bukan kepala keluarga, cari ID KK dari kepala keluarga
                    $idKepalaKeluarga = trim($row[16]); // Ambil NIA Kepala Keluarga

                    if (!empty($idKepalaKeluarga)) {
                        $idKkJemaat = DB::table('kk_jemaat')
                            ->join('jemaat', 'kk_jemaat.id_jemaat', '=', 'jemaat.id_jemaat')
                            ->where('jemaat.nia', $idKepalaKeluarga)
                            ->value('id_kk_jemaat');

                        if ($idKkJemaat) {
                            // Pastikan kolom hubungan keluarga tidak null atau kosong
                            $hubunganKeluarga = isset($row[17]) && !empty(trim($row[17])) ? trim($row[17]) : 'Tidak Diketahui';

                            // Simpan hubungan_keluarga
                            DB::table('hubungan_keluarga')->updateOrInsert(
                                ['id_jemaat' => $idJemaat],
                                [
                                    'id_kk_jemaat'      => $idKkJemaat,
                                    'hubungan_keluarga' => $hubunganKeluarga,
                                    'created_at'        => now(),
                                    'updated_at'        => now(),
                                ]
                            );
                        }
                    }
                }
            }

            DB::commit();
            return 'Data jemaat berhasil diunggah.';
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Konversi format angka Excel ke format tanggal (YYYY-MM-DD)
     */
    private function convertExcelDate($excelDate)
    {
        if (is_numeric($excelDate)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate)->format('Y-m-d');
        }
        return $excelDate; // Jika sudah dalam format tanggal yang benar
    }

    /**
     * Ambil ID Group Wilayah berdasarkan Wilayah
     */
    private function getIdGroupWilayah($wilayah)
    {
        $wilayahData = DB::table('group_wilayah')->where('nama_group_wilayah', $wilayah)->first();
        return $wilayahData ? $wilayahData->id_group_wilayah : 1; // Default ke ID 1 jika tidak ditemukan
    }
}