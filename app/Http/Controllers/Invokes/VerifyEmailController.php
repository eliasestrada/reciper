<?php

namespace App\Http\Controllers\Invokes;

use App\Http\Controllers\Controller;
use App\Models\User;

class VerifyEmailController extends Controller
{
    /**
     * @param string $token
     */
    public function __invoke(string $token)
    {
        if ($user = User::whereToken($token)->first()) {
            $user->update(['token' => null]);
            return redirect("/users/$user->username")
                ->withSuccess(trans('settings.email_verified'));
        }
        return redirect('/');
    }
}
