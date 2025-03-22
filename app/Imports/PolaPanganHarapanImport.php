<?php

namespace App\Imports;

use App\Models\PolaPanganHarapan;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PolaPanganHarapanRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Validation\ValidationException;

class PolaPanganHarapanImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 3;
    }

    private function mapRowToColumns($row)
    {
        return [
            'kelompok_pangan'   => $row[0],
            'tahun'             => $row[1],
            'energi_akt'        => $row[2],
            'energi_ideal'      => $row[3],
            'protein'           => $row[4],
            'skor_pph_akt'      => $row[5],
            'skor_pph_ideal'    => $row[6],
        ];
    }

    private function validateRow($row)
    {
        $mappedRow = $this->mapRowToColumns($row);
        
        // Get validation rules from PolaPanganHarapanRequest
        //$validationRules = (new PolaPanganHarapanRequest())->rules();
        
        // Optionally, you could define custom messages for specific fields
        $messages = [
            'kelompok_pangan.required'  => 'Kolom kelompok pangan wajib diisi.',
            'tahun.required'            => 'Kolom tahun wajib diisi.',
            'energi_akt.required'       => 'Kolom energi aktual wajib diisi.',
            'energi_akt.numeric'        => 'Kolom energi aktual harus berupa angka.',
            'protein.required'          => 'Kolom protein wajib diisi.',
            'protein.numeric'           => 'Kolom protein harus berupa angka.',
            'skor_pph_akt.required'     => 'Kolom skor pph aktual wajib diisi.',
            'skor_pph_akt.numeric'      => 'Kolom skor pph aktual harus berupa angka.',
            'skor_pph_ideal.required'   => 'Kolom skor pph ideal wajib diisi.',
            'skor_pph_ideal.numeric'    => 'Kolom skor pph ideal harus berupa angka.',
        ];
        
        // Perform validation
        $validator = Validator::make($mappedRow, $messages);

        // Add custom validation for komoditas existence
        $validator->after(function ($validator) use ($mappedRow) {
            if (!PolaPanganHarapan::groupBy('kelompok_pangan')->where('kelompok_pangan', $mappedRow['kelompok_pangan'])->exists()) {
                $validator->errors()->add('kelompok_pangan', "Nama Kelompok Pangan '{$mappedRow['kelompok_pangan']}' tidak ditemukan di database!");
            }
        });

        return $validator;
    }

    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        $errors = [];
        $validatedRows = [];
        
        // Load all komoditas ids at once for faster lookup
        $komoditasMap = PolaPanganHarapan::groupBy('kelompok_pangan')->pluck('kelompok_pangan');
         
        try {
            foreach ($rows as $index => $row) {
                $validator = $this->validateRow($row);

                if ($validator->fails()) {  
                    // Collect all errors for this row, indicating row number and details
                    $errorMessages = $validator->errors()->all();
                    $errors[] = "Baris " . ($index + 3) . ": " . implode(', ', $errorMessages); // Start row count at 3
                    continue; // Skip to the next row if validation fails
                }

                $mappedRow = $this->mapRowToColumns($row);

                // Prepare row for bulk insert if validation passes
                $validatedRows[] = [
                    'kelompok_pangan'=> $mappedRow['kelompok_pangan'],
                    'tahun'         => $mappedRow['tahun'],
                    'energi_akt'    => $mappedRow['energi_akt'],
                    'energi_ideal'  => $mappedRow['energi_ideal'],
                    'protein'       => $mappedRow['protein'],
                    'skor_pph_akt'  => $mappedRow['skor_pph_akt'],
                    'skor_pph_ideal'=> $mappedRow['skor_pph_ideal'],
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }

            if (empty($errors)) {
                // Insert validated rows if there are no errors
                PolaPanganHarapan::insert($validatedRows);
                DB::commit();
            } else {
                // Rollback transaction if there are validation errors
                DB::rollBack();
                session()->flash('errorImport', implode('<br>', $errors));
                throw new \Exception("Validation errors occurred during import.");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
