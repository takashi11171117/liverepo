<?php

namespace App\Http\Requests\Auth\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|unique:users,name|regex:/^[0-9a-zA-Z_\.\-]+$/',
            'password' => 'required|confirmed|regex:/\A(?=.*?[a-zA-Z])(?=.*?\d)[a-zA-Z\d]{8,}+\z/',
            'gender' => 'required|numeric',
            'birth' => 'required|date',
            'pref' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'gender' => '性別',
            'birth' => '生年月日',
            'pref' => '都道府県',
        ];
    }
}
