<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
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
            'nama_album'    => 'required|unique:albums',
            'keterangan'    => 'required',
            'foto'        => 'required',
            'fotos.*'        => 'file|image|mimes:jpeg,png,jpg|max:8024',
            ];
    }

    public function messages()
    {
        return [
            'nama_album.required'   => 'Nama album harus diisi.',
            'keterangan.required'   => 'Keterangan harus diisi.',
            'foto.mimes'          => 'File gambar harus dalam format jpeg, png, atau jpg.',
            'foto.max'            => 'Ukuran maksimal file gambar adalah 1MB.',
        ];
    }
}