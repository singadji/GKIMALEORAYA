<?php

namespace App\Imports;

use App\Models\NeracaBahanMakanan;
use App\Models\MasterNbmKomoditas;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\NeracaBahanMakananRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Validation\ValidationException;

class NeracaBahanMakananImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 3;
    }

    private function mapRowToColumns($row)
    {
        return [
            'komoditas' => $row[0],
            'tahun'     => $row[1],
            'energi'    => $row[2],
            'protein'   => $row[3],
            'lemak'     => $row[4],
        ];
    }

    private function validateRow($row)
    {
        $mappedRow = $this->mapRowToColumns($row);
        
        // Get validation rules from NeracaBahanMakananRequest
        $validationRules = (new NeracaBahanMakananRequest())->rules();
        
        // Optionally, you could define custom messages for specific fields
        $messages = [
            'tahun.required'        => 'Kolom tahun wajib diisi.',
            'energi.required' => 'Kolom energi wajib diisi.',
            'protein.required'     => 'Kolom protein wajib diisi.',
            'lemak.required'     => 'Kolom lemak wajib diisi.',
            'energi.numeric'  => 'Kolom energi harus berupa angka.',
            'protein.numeric'      => 'Kolom protein harus berupa angka.',
            'lemak.numeric'      => 'Kolom lemak harus berupa angka.',
        ];
        
        // Perform validation
        $validator = Validator::make($mappedRow, $validationRules, $messages);

        // Add custom validation for komoditas existence
        $validator->after(function ($validator) use ($mappedRow) {
            if (!MasterNbmKomoditas::where('nama_komoditas', $mappedRow['komoditas'])->exists()) {
                $validator->errors()->add('komoditas', "Nama Komoditas '{$mappedRow['komoditas']}' tidak ditemukan di database!");
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
        $komoditasMap = MasterNbmKomoditas::pluck('id_komoditas', 'nama_komoditas');
        
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
                    'id_komoditas'  => $komoditasMap[$mappedRow['komoditas']] ?? null,
                    'tahun'         => $mappedRow['tahun'],
                    'energi'        => $mappedRow['energi'],
                    'protein'       => $mappedRow['protein'],
                    'lemak'         => $mappedRow['lemak'],
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }

            if (empty($errors)) {
                // Insert validated rows if there are no errors
                NeracaBahanMakanan::insert($validatedRows);
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
