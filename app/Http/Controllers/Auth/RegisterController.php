<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Document;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        try {
            return view('auth.register', [
                'document' => cache()->rememberForever('document_agreement', function () {
                    return Document::whereId(1)->first()->toArray();
                }),
            ]);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return view('auth.register');
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $pwd_min = config('valid.settings.password.min');
        $pwd_max = config('valid.settings.password.max');
        $username_min = config('valid.settings.username.min');
        $username_max = config('valid.settings.username.max');

        return Validator::make($data, [
            'username' => "required|alpha_dash|string|min:$username_min|max:$username_max|unique:users|regex:/^[a-zA-Z0-9]+([_ -]?[a-zA-Z0-9])*$/",
            'password' => "required|string|min:$pwd_min|max:$pwd_max|confirmed",
        ], [
            'username.required' => trans('auth.username_required'),
            'username.string' => trans('auth.username_string'),
            'username.alpha_dash' => trans('auth.username_alpha_dash'),
            'username.regex' => trans('auth.username_regex'),
            'username.min' => trans('auth.username_min'),
            'username.max' => trans('auth.username_max'),
            'username.unique' => trans('auth.username_unique'),
            'password.required' => trans('auth.password_required'),
            'password.string' => trans('auth.password_string'),
            'password.min' => trans('auth.password_min'),
            'password.max' => trans('auth.password_max'),
            'password.confirmed' => trans('auth.password_confirmed'),
        ]);
    }

    // Create a new user instance after a valid registration.
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'token' => 'none',
        ]);
    }
}
