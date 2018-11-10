<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\EmailRequest;
use App\Http\Requests\Settings\GeneralRequest;
use App\Http\Requests\Settings\PasswordRequest;
use App\Http\Requests\Settings\SettingsGeneralRequest;
use App\Models\User;
use App\Notifications\EmailConfirmationNotification;
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
        if (\Hash::check(request('old_password'), user()->password)) {
            user()->update([
                'password' => \Hash::make(request('password')),
            ]);
            return back()->withSuccess(trans('settings.saved'));
        } else {
            return back()->withError(trans('settings.pwd_wrong'));
        }
    }

    /**
     * @param EmailRequest $request
     * @return void
     */
    public function updateEmail(EmailRequest $request)
    {
        if (empty(request('email'))) {
            user()->update(['email' => null, 'token' => 'none']);
            return back()->withSuccess(trans('settings.email_is_empty'));
        }

        user()->update(['email' => request('email'), 'token' => str_random(20)]);
        user()->notify(new EmailConfirmationNotification(user()));

        return back()->withSuccess(trans('settings.saved_now_verify_email'));
    }
}
