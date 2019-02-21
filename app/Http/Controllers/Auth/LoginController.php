<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
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
     * @return string
     */
    public function username()
    {
        return 'username';
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
            $this->username() => 'required|alpha_dash|string',
            'password' => 'required|string',
        ], [
            'username.required' => trans('auth.username_required'),
            'username.string' => trans('auth.username_string'),
            'username.alpha_dash' => trans('auth.username_alpha_dash'),
            'password.required' => trans('auth.password_required'),
            'password.string' => trans('auth.password_string'),
        ]);
    }
}
