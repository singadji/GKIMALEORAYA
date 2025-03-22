<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'nama_menu' => 'required',
            'link_menu' => 'required',
            //'aktif'     => 'required',
            'images'    => 'file|mimes:jpeg,png,jpg|max:10000',
            'video'     => 'file|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quickdatetime,x-msvideo,x-ms-wmv |max:9000000',
            'dokumen'   => 'file|mimes:pdf|max:10000',
            ];
    }

    public function messages()
    {
        return [
            'nama_menu.required' => 'Nama menu harus diisi.',
            'link_menu.required' => 'Link menu harus diisi.',
            //'aktif.required' => 'Status menu harus diisi.',
            'images.mimes' => 'File gambar harus dalam format jpeg, png, atau jpg.',
            'images.max'   => 'Ukuran maksimal file gambar adalah 10MB.',
            'video.mimes'  => 'File video harus dalam format mp4, flv, mpegURL, MP2T, 3gpp, quicktime, avi, atau wmv.',
            'video.max'    => 'Ukuran maksimal file video adalah 9GB.',
            'dokumen.mimes'=> 'File dokumen harus dalam format PDF.',
            'dokumen.max'  => 'Ukuran maksimal file dokumen adalah 10MB.',
        ];
    }
}