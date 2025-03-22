<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtikelRequest extends FormRequest
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
            'judul_artikel'=> 'required',
            'kategori' => 'required',
            'isi_artikel' => 'required',
            //'publish' => 'required',
            'gambar'    => 'file|mimes:jpeg,png,jpg|max:10000',
            ];
    }

    public function messages()
    {
        return [
            'judul_artikel.required' => 'Judul artikel harus diisi.',
            'kategori.required' => 'Kategori harus diisi.',
            'isi_artikel.required' => 'Isi artikel menu harus diisi.',
            'gambar.mimes' => 'File gambar harus dalam format jpeg, png, atau jpg.',
            'gambar.max'   => 'Ukuran maksimal file gambar adalah 1MB.',
        ];
    }
}