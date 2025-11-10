<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterKomoditasRequest extends FormRequest
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
            'nama'              => 'required',
            'jenis_komoditas'   => 'required',
            'satuan'            => 'required',
            'gambar'            => 'required',
            'gambar'            => 'file|mimes:jpeg,png,jpg|max:10000',
            ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama komoditas harus diisi.',
            'jenis_komoditas.required' => 'Jenis komoditas harus diisi.',
            'satuan.required' => 'Jenis komoditas harus diisi.',
            'gambar.required' => 'Gambar harus diisi.',

            'gambar.mimes' => 'File gambar harus dalam format jpeg, png, atau jpg.',
            'gambar.max'   => 'Ukuran maksimal file gambar adalah 1MB.',
        ];
    }
}