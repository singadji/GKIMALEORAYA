<?php

namespace App\Http\Requests\Login;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required|exists:tr_user,username',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Mohon masukkan username anda.',
            'username.exists' => 'Username tidak dikenal.',
            'password.required' => 'Mohon masukkan password anda.',
        ];
    }
}
