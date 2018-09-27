<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\PasswordRequest;
use App\Http\Requests\Settings\SettingsPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('settings.password.edit');
    }

    /**
     * @param SettingsPasswordRequest $request
     */
    public function update(PasswordRequest $request)
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
