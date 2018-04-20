<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsPhotoRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize()
    {
        return true;
    }

    // Get the validation rules that apply to the request.
    public function rules()
    {
        return [
            'image' => 'image|nullable|max:1999'
        ];
	}
	
	// Get the validation messages that apply to the request.
	public function messages() {
		return [
			'image.image' => 'Файл не является изображением',
			'image.max' => 'Изображение не должно превышать :max Кбайт',
			'image.uploaded' => 'Загрузка не удалась, возможно это связано с большим разширением, изображение не должно превышать 1999 Кбайт'	
		];
	}
}
