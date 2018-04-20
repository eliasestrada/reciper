<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipePublichRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize()
    {
        return true;
    }

	/**
	 * Get the validation rules that apply to the request, 
	 * only if recipe is ready to publish
	 */
    public function rules()
    {
        if ($this->ready == 1) {
			return [
				'название' => 'min:5|max:199',
				'описание' => 'min:20|max:2000',
				'ингридиенты' => 'min:20|max:5000',
				'совет' => 'max:5000',
				'приготовление' => 'min:80|max:10000',
				'время' => 'numeric|digits_between:0,1000',
				'изображение' => 'image|nullable|max:1999'
			];
		}
		return [];
    }
}
