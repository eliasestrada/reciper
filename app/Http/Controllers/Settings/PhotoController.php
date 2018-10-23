<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\Traits\PhotoControllerHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\PhotoRequest;
use App\Http\Requests\Settings\SettingsPhotoRequest;
use App\Models\User;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    use PhotoControllerHelpers;

    public function edit()
    {
        return view('settings.photo.edit');
    }

    /**
     * @param SettingsPhotoRequest $request
     */
    public function update(PhotoRequest $request)
    {
        if (!$image = $request->file('image')) {
            return back()->withError(trans('settings.there_are_no_file'));
        }

        $extention = $image->getClientOriginalExtension();
        $file_name = set_image_name($extention, 'user' . user()->id);

        $this->deleteOldFileFromStorage(user()->image, 'users');
        $this->saveImageIfExist($image, $file_name);
        $this->saveFileNameToDB($file_name);

        return back()->withSuccess(trans('settings.saved'));
    }

    public function destroy()
    {
        $this->deleteOldFileFromStorage(user()->image, 'users');
        user()->update(['image' => 'default.jpg']);

        return back()->withSuccess(trans('settings.photo_deleted'));
    }
}
