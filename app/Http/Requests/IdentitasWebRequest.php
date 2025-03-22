<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IdentitasWebRequest extends FormRequest
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
            'nama_perusahaan'   => 'required',
            'url'               => 'required',
            'email'             => 'required',
            'alamat'            => 'required',
            'telepon'           => 'required',
            'facebook'          => 'required',
            'instagram'         => 'required',
            'youtube'           => 'required',
            'tag_line'          => 'required',
            'deskripsi'         => 'required',
            'keyword'           => 'required',
            'profil'            => 'required',
            'logo'              => 'required',
            'favicon'           => 'required',
            'logo'              => 'file|mimes:jpeg,png,jpg|max:10000',
            'favicon'           => 'file|mimes:jpeg,png,jpg|max:10000',
            ];
    }

    public function messages()
    {
        return [
            'nama_perusahaan.required' => 'Nama perusahaan harus diisi.',
            'url.required' => 'Alamat web harus diisi.',
            'email.required' => 'Email harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
            'telepon.required' => 'Telepon harus diisi.',
            'facebook.required' => 'Facebook harus diisi.',
            'instagram.required' => 'Instagram harus diisi.',
            'youtube.required' => 'Youtube harus diisi.',
            'tag_line.required' => 'Tag line harus diisi.',
            'deskripsi.required' => 'Deskripsi harus diisi.',
            'keyword.required' => 'Keyword harus diisi.',
            'profil.required' => 'Profil harus diisi.',
            'logo.required' => 'Logo harus diisi.',
            'favicon.required' => 'Favicon harus diisi.',
            'logo.mimes' => 'File logo harus dalam format jpeg, png, atau jpg.',
            'logo.max'   => 'Ukuran maksimal file logo adalah 10MB.',
            'favicon.mimes'  => 'File video harus dalam format mp4, flv, mpegURL, MP2T, 3gpp, quicktime, avi, atau wmv.',
            'favicon.max'    => 'Ukuran maksimal file favicon adalah 10Kb.',
        ];
    }
}