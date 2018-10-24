<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\Traits\PhotoControllerHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\PhotoRequest;
use App\Http\Requests\Settings\SettingsPhotoRequest;
use App\Jobs\DeleteImageJob;
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

        if (user()->image != 'default.jpg') {
            DeleteImageJob::dispatch(user()->image);
        }

        $image_name = $this->saveImageIfExist($image);
        $this->updateImageInDatabase((string) $image_name);

        return back()->withSuccess(trans('settings.saved'));
    }

    public function destroy()
    {
        if (user()->image != 'default.jpg') {
            DeleteImageJob::dispatch(user()->image);
        }

        user()->update(['image' => 'default.jpg']);

        return back()->withSuccess(trans('settings.photo_deleted'));
    }
}
