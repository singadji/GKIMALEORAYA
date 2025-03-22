<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email'     => 'required|unique:users',
            'nama'      => 'required',
            'role'      => 'required',
            ];
    }

    public function messages()
    {
        return [
            'email.required'   => 'Email harus diisi.',
            'nama.required'   => 'Nama harus diisi.',
            'role.required'   => 'Anda belum memilih role.'
        ];
    }
}