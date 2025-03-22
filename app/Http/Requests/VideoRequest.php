<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
            'judul_video'   => 'required',
            'link_youtube'  => 'required',
            ];
    }

    public function messages()
    {
        return [
            'judul_video.required' => 'Judul video harus diisi.',
            'link_youtube.required' => 'Link youtube harus diisi.',
        ];
    }
}