<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeSaveRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize()
    {
        return true;
    }

    // Get the validation messages that apply to the request.
    public function rules()
    {
        return [
            'title'        => 'max:199',
            'intro'        => 'max:2000',
            'ingredients'  => 'max:5000',
            'advice'       => 'max:5000',
            'text'         => 'max:10000',
            'time'         => 'numeric|digits_between:0,1999',
            'image'        => 'image|nullable|max:1999'
        ];
	}


    public function messages()
    {
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
}
