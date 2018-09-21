<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\Traits\SettingsPhotoControllerHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SettingsPhotoRequest;
use App\Models\User;
use Illuminate\Http\Request;

class SettingsPhotoController extends Controller
{
    use SettingsPhotoControllerHelper;

    public function edit()
    {
        return view('settings.photo.edit');
    }

    /**
     * @param SettingsPhotoRequest $request
     */
    public function update(SettingsPhotoRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $extention = $image->getClientOriginalExtension();
            $file_name = set_image_name($extention, 'user' . user()->id);

            $this->deleteOldFileFromStorage(user()->image, 'users');
            $this->saveFileToStorage($image, $file_name);
            $this->saveFileNameToDB($file_name);
        } elseif ($request->delete == 1) {
            $this->deleteOldFileFromStorage(user()->image, 'users');
            $this->saveFileNameToDB();
        }
        return redirect('/settings/photo/edit')->withSuccess(trans('settings.saved'));
    }
}
