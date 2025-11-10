<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NeracaPanganRequest extends FormRequest
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
            'bulan' => 'required',
            'tahun' => 'required',
            'ketersediaan' => 'required',
            'ketersediaan' => 'numeric',
            'konsumsi' => 'required',
            'konsumsi' => 'numeric',
            ];
    }

    public function messages()
    {
        return [
            'bulan.required' => 'Bulan harus diisi.',
            'tahun.required' => 'Tahun harus diisi.',
            'ketersediaan.required' => 'Ketersediaan harus diisi.',
            'konsumsi.required' => 'Konsumsi harus diisi.',
        ];
    }
}