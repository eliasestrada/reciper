<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\Traits\PhotoControllerHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\PhotoRequest;
use App\Http\Requests\Settings\SettingsPhotoRequest;
use App\Jobs\DeleteFileJob;
use App\Models\User;
use Illuminate\Http\Request;
use Predis\Connection\ConnectionException;

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
            try {
                DeleteFileJob::dispatch([
                    'public/users/' . user()->photo,
                    'public/small/users/' . user()->photo,
                ]);
            } catch (ConnectionException $e) {
                logger()->error("DeleteFileJob was not dispatched. {$e->getMessage()}");
            }
        }

        $photo_name = $this->savePhotoIfExist($photo);
        $this->updatePhotoInDatabase((string) $photo_name);

        return back()->withSuccess(trans('settings.saved'));
    }

    public function destroy()
    {
        if (user()->photo != 'default.jpg') {
            try {
                DeleteFileJob::dispatch([
                    'public/users/' . user()->photo,
                    'public/small/users/' . user()->photo,
                ]);
            } catch (ConnectionException $e) {
                logger()->error("DeleteFileJob was not dispatched. {$e->getMessage()}");
            }
        }

        user()->update(['photo' => 'default.jpg']);

        return back()->withSuccess(trans('settings.photo_deleted'));
    }
}
