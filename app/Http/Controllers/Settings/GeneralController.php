<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\GeneralRequest;
use App\Http\Requests\Settings\PasswordRequest;
use App\Http\Requests\Settings\SettingsGeneralRequest;
use App\Models\User;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index()
    {
        return view('settings.general.index');
    }

    /**
     * @param SettingsGeneralRequest $request
     */
    public function updateGeneral(GeneralRequest $request)
    {
        user()->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return back()->withSuccess(trans('settings.saved'));
    }

    /**
     * @param SettingsPasswordRequest $request
     */
    public function updatePassword(PasswordRequest $request)
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
}
