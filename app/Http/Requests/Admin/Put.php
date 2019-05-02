<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class Put extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = ((call_user_func($this->getRouteResolver()))->parameters())['id'];
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $id . ',id',
            'password' => 'confirmed|regex:/\A(?=.*?[a-zA-Z])(?=.*?\d)[a-zA-Z\d]{8,}+\z/'
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
