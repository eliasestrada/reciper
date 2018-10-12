<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\ValidationException;
use Validator;

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
        return view('auth.register', [
            'document' => Document::whereId(1)->first(),
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (strpos(strtolower($data['name']), 'admin') !== false || strpos(strtolower($data['name']), 'админ') !== false) {
            throw ValidationException::withMessages(['name' => [trans('auth.incorect_name')]]);
        }

        $name_min = config('valid.settings.general.name.min');
        $name_max = config('valid.settings.general.name.max');
        $pwd_min = config('valid.settings.password.min');
        $pwd_max = config('valid.settings.password.max');
        $email_max = config('valid.settings.email.max');

        return Validator::make($data, [
            'name' => "required|string|min:$name_min|max:$name_max",
            'email' => "required|string|email|max:$email_max|unique:users",
            'password' => "required|string|min:$pwd_min|max:$pwd_max|confirmed",
        ], [
            'name.required' => trans('auth.name_required'),
            'name.string' => trans('auth.name_string'),
            'name.min' => trans('auth.name_min'),
            'name.max' => trans('auth.name_max'),
            'email.required' => trans('auth.email_required'),
            'email.string' => trans('auth.email_string'),
            'email.email' => trans('auth.email_email'),
            'email.max' => trans('auth.email_max'),
            'email.unique' => trans('auth.email_unique'),
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
            'visitor_id' => visitor_id(),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
