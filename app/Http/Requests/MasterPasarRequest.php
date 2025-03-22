<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterPasarRequest extends FormRequest
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
            'nama_pasar'   => 'required',
            'alamat_pasar'  => 'required',
            ];
    }

    public function messages()
    {
        return [
            'nama_pasar.required' => 'Nama pasar harus diisi.',
            'alamat_pasar.required' => 'Alamat pasar harus diisi.',
        ];
    }
}