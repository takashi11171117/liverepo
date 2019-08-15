<?php

namespace App\Http\Requests\Front\User\Profile;

use App\Http\Request;
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
    public function rules(Request $request)
    {
        $args = [
            'user_id' => 'required|numeric',
            'user_name01' => 'nullable|max:255',
            'user_name02' => 'nullable|max:255',
            'image' => 'nullable|image|max:20000',
            'url' => 'nullable|max:100|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'description' => 'nullable|max:1200',
            'gender' => 'required|numeric',
            'birth' => 'required|date',
            'show_mail_flg' => 'required|numeric'
        ];

        return $args;
    }
}
