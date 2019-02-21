<?php

namespace App\Http\Controllers\Settings;

use Predis\Connection\ConnectionException;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Jobs\DeleteFileJob;
use App\Http\Requests\Settings\PhotoRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Controllers\Settings\PhotoHelpers;

class PhotoController extends Controller
{
    use PhotoHelpers;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show settings photo page
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('settings.photo.index');
    }

    /**
     * @param \App\Http\Requests\Settings\PhotoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PhotoRequest $request): RedirectResponse
    {
        if (!$photo = $request->file('photo')) {
            return back()->withError(trans('settings.there_are_no_file'));
        }

        if (user()->photo != 'default.jpg') {
            try {
                DeleteFileJob::dispatch([
                    'public/big/users/' . user()->photo,
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

    /**
     * Dispatch DeleteFileJob and update user photo to default.jpg
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(): RedirectResponse
    {
        if (user()->photo != 'default.jpg') {
            try {
                DeleteFileJob::dispatch([
                    'public/big/users/' . user()->photo,
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
