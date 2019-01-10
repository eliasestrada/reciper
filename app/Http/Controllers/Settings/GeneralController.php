<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\EmailRequest;
use App\Http\Requests\Settings\GeneralRequest;
use App\Http\Requests\Settings\PasswordRequest;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GeneralController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show general settings page
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('settings.general.index');
    }

    /**
     * Update general settings like user name and status
     *
     * @param \App\Http\Requests\Settings\GeneralRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateGeneral(GeneralRequest $request): RedirectResponse
    {
        user()->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return back()->withSuccess(trans('settings.saved'));
    }

    /**
     * Update user's password
     *
     * @param \App\Http\Requests\Settings\PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(PasswordRequest $request): RedirectResponse
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
     * Update user's email address
     *
     * @param \App\Http\Requests\Settings\EmailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEmail(EmailRequest $request): RedirectResponse
    {
        $user = user();

        if (empty(request('email'))) {
            user()->update(['email' => null, 'token' => 'none']);
            return back()->withSuccess(trans('settings.email_is_empty'));
        }

        // Return back if he already changed email
        if (cache()->has("user:{$user->id}:changed_email")) {
            return back()->withError(trans('settings.email_change_once_per_week'));
        }

        $user->update(['email' => request('email'), 'token' => str_random(30)]);
        $user->notify(new VerifyEmailNotification($user));

        // Add user to cache for 1 week
        cache()->put("user:{$user->id}:changed_email", 1, 10080);

        return back()->withSuccess(trans('settings.saved_now_verify_email'));
    }
}
