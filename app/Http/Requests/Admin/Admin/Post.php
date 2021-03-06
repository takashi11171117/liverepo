<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;

class Post extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required|confirmed|regex:/\A(?=.*?[a-zA-Z])(?=.*?\d)[a-zA-Z\d]{8,}+\z/'
        ];
    }

    public function attributes()
    {
        return [
            'name' => '名前',
            'email' => 'メールアドレス',
        ];
    }

    public function messages()
    {
        return [
            'password.confirmed' => 'パスワードが異なります。',
            'password.regex' => '８文字以上、アルファベット・数字を、最低1文字以上は使用してください。',
        ];
    }
}
