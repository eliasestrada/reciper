<?php

namespace App\Http\Controllers;

use App\Helpers\Traits\SettingsControllerHelper;
use App\Http\Requests\Settings\SettingsPhotoRequest;
use App\Http\Requests\Settings\SettingsUpdateHomeDataRequest;
use App\Http\Requests\Settings\SettingsUpdateUserDataRequest;
use App\Http\Requests\Settings\SettingsUpdateUserPasswordRequest;
use App\Models\Title;
use App\Models\User;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    use SettingsControllerHelper;

    /**
     * @param SettingsPhotoRequest $request
     */
    public function updatePhoto(SettingsPhotoRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $extention = $image->getClientOriginalExtension();
            $file_name = setImageName($extention, 'user' . user()->id);

            $this->deleteOldFileFromStorage(user()->image, 'users');
            $this->saveFileToStorage($image, $file_name);
            $this->saveFileNameToDB($file_name);
        } elseif ($request->delete == 1) {
            $this->deleteOldFileFromStorage(user()->image, 'users');
            $this->saveFileNameToDB();
        }
        return redirect('/settings/photo')->withSuccess(trans('settings.saved'));
    }

    /**
     * @param SettingsUpdateUserDataRequest $request
     */
    public function updateUserData(SettingsUpdateUserDataRequest $request)
    {
        user()->update(['name' => $request->name]);
        return back()->withSuccess(trans('settings.saved'));
    }

    /**
     * @param SettingsUpdateUserPasswordRequest $request
     */
    public function updateUserPassword(SettingsUpdateUserPasswordRequest $request)
    {
        if (\Hash::check($request->old_password, user()->password)) {
            user()->update([
                'password' => \Hash::make($request->password),
            ]);
            return back()->withSuccess(trans('settings.saved'));
        } else {
            return back()->withError(trans('settings.pwd_wrong'));
        }
    }

    /**
     * @param SettingsUpdateHomeDataRequest $request
     */
    public function updateIntroData(SettingsUpdateHomeDataRequest $request)
    {
        Title::whereName('intro')->update([
            'title_' . locale() => $request->title,
            'text_' . locale() => $request->text,
        ]);

        return back()->withSuccess(trans('settings.saved'));
    }

    /**
     * @param Request $request
     */
    public function updateFooterData(Request $request)
    {
        $data = $this->validate($request,
            ['text' => 'max:190'],
            ['text.max' => trans('settings.footer_text_max')]
        );

        Title::whereName('footer')->update([
            'text_' . locale() => $request->text,
        ]);

        return back()->withSuccess(trans('settings.saved'));
    }
}
