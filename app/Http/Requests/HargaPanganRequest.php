<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HargaPanganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'minggu'   => 'required',
            'bulan'  => 'required',
            'nama_pasar'  => 'required',
            'tahun'  => 'required',
            'harga'  => 'required',
            ];
    }

    public function messages()
    {
        return [
            'minggu.required' => 'Minggu harus diisi.',
            'bulan.required' => 'Bulan harus diisi.',
            'nama_pasar.required' => 'Pasar harus diisi.',
            'tahun.required' => 'Tahun harus diisi.',
            'harga.required' => 'Harga harus diisi.',
        ];
    }
}