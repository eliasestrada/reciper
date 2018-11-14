<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'photo' => 'image|mimes:jpg,png,jpeg|nullable|max:1999',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'photo.image' => trans('settings.photo_image'),
            'photo.max' => trans('settings.photo_max'),
            'photo.uploaded' => trans('settings.photo_uploaded'),
            'photo.mimes' => trans('settings.photo_mimes'),
        ];
    }
}
