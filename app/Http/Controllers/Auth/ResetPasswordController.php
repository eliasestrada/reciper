<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    // Where to redirect users after resetting their password.
    protected $redirectTo = '/dashboard';

    // Create a new controller instance.
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        $pwd_min = config('valid.settings.password.min');
        $pwd_max = config('valid.settings.password.max');

        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => "required|min:$pwd_min|max:$pwd_max|confirmed",
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'token.required' => trans('settings.token_required'),
            'email.required' => trans('settings.email_required'),
            'email.email' => trans('settings.email_email'),
            'password.required' => trans('settings.pwd_required'),
            'password.min' => trans('settings.pwd_min'),
            'password.max' => trans('settings.pwd_max'),
            'password.confirmed' => trans('settings.pwd_confirmed'),
        ];
    }
}
