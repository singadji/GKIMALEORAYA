<?php

namespace App\Imports;

use App\Models\NeracaPangan;
use App\Models\MasterNbKomoditas;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\NeracaPanganRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Validation\ValidationException;

class NeracaPanganImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 3;
    }

    private function mapRowToColumns($row)
    {
        return [
            'komoditas'     => $row[0],
            'bulan'         => $row[1],
            'tahun'         => $row[2],
            'ketersediaan'  => $row[3],
            'konsumsi'      => $row[4],
        ];
    }

    private function validateRow($row)
    {
        $mappedRow = $this->mapRowToColumns($row);
        
        // Get validation rules from NeracaPanganRequest
        $validationRules = (new NeracaPanganRequest())->rules();
        
        // Optionally, you could define custom messages for specific fields
        $messages = [
            'komoditas.required'    => 'Kolom komoditas wajib diisi.',
            'bulan.required'        => 'Kolom bulan wajib diisi.',
            'tahun.required'        => 'Kolom tahun wajib diisi.',
            'ketersediaan.required' => 'Kolom ketersediaan wajib diisi.',
            'konsumsi.required'     => 'Kolom konsumsi wajib diisi.',
            'ketersediaan.numeric'  => 'Kolom ketersediaan harus berupa angka.',
            'konsumsi.numeric'      => 'Kolom konsumsi harus berupa angka.',
        ];
        
        // Perform validation
        $validator = Validator::make($mappedRow, $validationRules, $messages);

        // Add custom validation for komoditas existence
        $validator->after(function ($validator) use ($mappedRow) {
            if (!MasterNbKomoditas::where('nama_komoditas', $mappedRow['komoditas'])->exists()) {
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
        $komoditasMap = MasterNbKomoditas::pluck('id', 'nama_komoditas');
        
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
                    'id_komoditas'   => $komoditasMap[$mappedRow['komoditas']] ?? null,
                    'bulan'          => $mappedRow['bulan'],
                    'tahun'          => $mappedRow['tahun'],
                    'ketersediaan'   => $mappedRow['ketersediaan'],
                    'konsumsi'       => $mappedRow['konsumsi'],
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }

            if (empty($errors)) {
                // Insert validated rows if there are no errors
                NeracaPangan::insert($validatedRows);
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
