<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
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
            'photo' => 'image|nullable|max:1999',
        ];
    }

    // Get the validation messages that apply to the request.
    public function messages()
    {
        return [
            'photo.image' => trans('settings.photo_image'),
            'photo.max' => trans('settings.photo_max'),
            'photo.uploaded' => trans('settings.photo_uploaded'),
        ];
    }
}
