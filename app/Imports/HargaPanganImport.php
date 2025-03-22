<?php

namespace App\Imports;

use App\Models\HargaPangan;
use App\Models\HargaPanganDetail;
use App\Models\MasterKomoditas;
use App\Models\MasterPasar;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class HargaPanganImport
{
    public function import($file)
    {
        // Load file Excel
        $path = $file->getRealPath();
        $data = Excel::toArray([], $path, null, \Maatwebsite\Excel\Excel::XLSX);

        // Ambil data dari sheet pertama
        $rows = $data[0];

        // Validasi header file
        $requiredHeaders = ['Komoditas', 'Tahun', 'Bulan', 'Minggu'];
        $headers = array_slice($rows[0], 0, 4); // Kolom utama
        if (array_diff($requiredHeaders, $headers)) {
            throw new \Exception('Format file tidak valid.');
        }

        // Ambil nama pasar dari header
        $pasarHeaders = array_slice($rows[0], 4);
        $komoditasList = array_column(array_slice($rows, 1), 0); // Semua komoditas dari baris data

        // Validasi komoditas dan pasar
        $invalidKomoditas = collect($komoditasList)
            ->diff(MasterKomoditas::whereIn('nama', $komoditasList)->pluck('nama')->toArray())
            ->toArray();
        $invalidPasar = collect($pasarHeaders)
            ->diff(MasterPasar::whereIn('nama_pasar', $pasarHeaders)->pluck('nama_pasar')->toArray())
            ->toArray();

        if ($invalidKomoditas) {
            throw new \Exception('Komoditas tidak ada pada tabel: ' . implode(', ', $invalidKomoditas));
        }
        if ($invalidPasar) {
            throw new \Exception('Pasar tidak pada tabel: ' . implode(', ', $invalidPasar));
        }

        // Proses data
        DB::beginTransaction();
        try {
            foreach (array_slice($rows, 1) as $row) {
                foreach ($pasarHeaders as $index => $pasar) {
                    $harga = $row[$index + 4]; // Harga ada di kolom pasar
                    if (!is_null($harga)) {
                        // Cek apakah entri harga_pangan sudah ada untuk kombinasi pasar dan minggu
                        $hargaPangan = HargaPangan::firstOrCreate(
                            [
                                'tahun' => $row[1],
                                'bulan' => $row[2],
                                'minggu_ke' => $row[3],
                                'id_pasar' => MasterPasar::where('nama_pasar', $pasar)->value('id'),
                            ]
                        );

                        // Insert ke tabel harga_pangan_detail
                        HargaPanganDetail::create([
                            'id_harga_pangan' => $hargaPangan->id,
                            'id_komoditas' => MasterKomoditas::where('nama', $row[0])->value('id'),
                            'harga' => $harga,
                        ]);
                    }
                }
            }

            DB::commit();
            return 'Data berhasil diunggah.';
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
