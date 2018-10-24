<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\Traits\PhotoControllerHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\PhotoRequest;
use App\Http\Requests\Settings\SettingsPhotoRequest;
use App\Jobs\DeletePhotoJob;
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
        if (!$photo = $request->file('photo')) {
            return back()->withError(trans('settings.there_are_no_file'));
        }

        if (user()->photo != 'default.jpg') {
            DeletePhotoJob::dispatch(user()->photo);
        }

        $photo_name = $this->savePhotoIfExist($photo);
        $this->updatePhotoInDatabase((string) $photo_name);

        return back()->withSuccess(trans('settings.saved'));
    }

    public function destroy()
    {
        if (user()->photo != 'default.jpg') {
            DeletePhotoJob::dispatch(user()->photo);
        }

        user()->update(['photo' => 'default.jpg']);

        return back()->withSuccess(trans('settings.photo_deleted'));
    }
}
