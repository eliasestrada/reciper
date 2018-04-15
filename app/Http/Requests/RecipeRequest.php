<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
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
            'название' => 'max:199',
            'описание' => 'max:2000',
            'ингридиенты' => 'max:5000',
            'совет' => 'max:5000',
            'приготовление' => 'max:10000',
            'время' => 'numeric|digits_between:0,1000',
            'изображение' => 'image|nullable|max:1999'
        ];
    }
}
