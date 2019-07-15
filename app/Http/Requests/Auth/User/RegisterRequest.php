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
            'name' => 'required',
            'password' => 'required',
            'gender' => 'required|numeric',
            'birth' => 'required|date',
        ];
    }

    public function attributes()
    {
        return [
            'gender' => '性別',
            'birth' => '生年月日',
        ];
    }
}
