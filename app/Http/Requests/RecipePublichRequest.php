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
				'title'        => 'min:5|max:199',
				'intro'        => 'min:20|max:2000',
				'ingredients'  => 'min:20|max:5000',
				'advice'       => 'max:5000',
				'text'         => 'min:80|max:10000',
				'time'         => 'numeric|digits_between:0,1000',
				'image'        => 'image|nullable|max:1999'
			];
		}
		return [];
	}
	
	// Get the validation messages that apply to the request.
    public function messages()
    {
        if ($this->ready == 1) {
			return [
				'title.min'             => 'Название рецепта не должно быть менее 5 символов',
				'title.max'             => 'Название рецепта не должно быть более 199 символов',
				'intro.min'             => 'Краткое описание не должно быть менее 20 символов',
				'intro.max'             => 'Краткое описание не должно быть не более 2000 символов',
				'ingredients.min'       => 'Колличество символов в поле ингридиенты не должно быть менее 
											20 символов',
				'ingredients.max'       => 'Колличество символов в поле ингридиенты не должно быть не более 
											5000 символов',
				'advice.max'            => 'Колличество символов в поле совет не должно быть не более 
											5000 символов',
				'text.min'              => 'Колличество символов в поле приготовление не должно быть менее 
											80 символов',
				'text.max'              => 'Колличество символов в поле приготовление не должно быть более 
											10 000 символов',
				'time.numeric'          => 'Время должно быть числом',
				'time.digits_between'   => 'Время должно быть числом между 0 и 1999',
				'image.image'           => 'Изображение должно быть файлом изображения JPG',
				'image.max'             => 'Максимальный допустимый обьем изображения 1999 кбайт'
			];
		}
		return [];
    }
}
