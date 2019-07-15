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
            'user_name01' => 'nullable|max:255',
            'user_name02' => 'nullable|max:255',
            'image' => 'nullable|image|max:10000',
        ];

        return $args;
    }
}
