<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * This controller handles authenticating users for the application and
     * redirecting them to your home screen. The controller uses a trait
     * to conveniently provide its functionality to your applications.
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => trans('auth.email_required'),
            'email.string' => trans('auth.email_string'),
            'password.required' => trans('auth.password_required'),
            'password.string' => trans('auth.password_string'),
        ]);
    }
}
