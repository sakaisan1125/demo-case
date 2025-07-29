<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check(); // 認証済みのみ許可
    }

    public function rules()
    {
        return [
            'name'        => 'required',
            'description' => 'required|max:255',
            'image'       => 'required|image|mimes:jpeg,png|max:4096',
            'category_id' => 'required|integer|exists:categories,id', // セレクトボックス想定
            'condition'   => 'required|string',
            'price'       => 'required|integer|min:0',
        ];
    }
}
