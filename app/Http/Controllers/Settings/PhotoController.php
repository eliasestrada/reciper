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

    public function index()
    {
        return view('settings.photo.index');
    }

    /**
     * @param SettingsPhotoRequest $request
     */
    public function update(PhotoRequest $request)
    {
        if (!$image = $request->file('image')) {
            return back()->withError(trans('settings.there_are_no_file'));
        }

        $this->deleteOldImage(user()->image, 'users');
        $image_name = $this->saveImageIfExist($image);
        $this->updateImageInDatabase((string) $image_name);

        return back()->withSuccess(trans('settings.saved'));
    }

    public function destroy()
    {
        $this->deleteOldImage(user()->image);
        user()->update(['image' => 'default.jpg']);

        return back()->withSuccess(trans('settings.photo_deleted'));
    }
}
