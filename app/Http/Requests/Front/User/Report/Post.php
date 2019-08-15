<?php

namespace App\Http\Requests\Front\User\Report;

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
            'title' => 'required|max:255',
            'content' => 'required|max:40000',
            'status' => 'required',
            'rating' => 'required',
            'images.*' => 'nullable|image|max:20000',
            'place_tags' => 'required',
            'player_tags' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'content' => '本文',
            'status' => 'ステータス',
            'rating' => '評価',
            'images.0' => '画像1',
            'place_tags' => '開催場所',
            'player_tags' => '出演者',
        ];
    }
}
