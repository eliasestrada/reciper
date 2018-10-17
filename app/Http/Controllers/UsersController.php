<?php

namespace App\Http\Controllers;

use App\Helpers\Xp;
use App\Models\Recipe;
use App\Models\User;
use GuzzleHttp\Psr7\Request;

class UsersController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('users.index', ['users' => User::whereActive(1)->orderBy('name')->paginate(36)->onEachSide(1)]);
    }

    /**
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function show($username)
    {
        $user = User::whereUsername($username)->first();
        $recipes = Recipe::whereUserId($user->id)
            ->withCount('likes')
            ->withCount('views')
            ->withCount('favs')
            ->done(1)
            ->latest()
            ->paginate(20)
            ->onEachSide(1);

        $xp = new Xp($user->id);

        return view('users.show', compact('recipes', 'user', 'xp'));
    }

    /**
     * Recover users' account
     */
    public function store()
    {
        user()->update(['active' => 1]);
        return redirect('/users/' . user()->username)->withSuccess(
            trans('users.account_recovered')
        );
    }

    /**
     * @return \Illuminate\View\View
     */
    public function my_recipes()
    {
        $recipes_ready = Recipe::whereUserId(user()->id)
            ->selectBasic()
            ->done(1)
            ->latest()
            ->paginate(20)
            ->onEachSide(1);

        $recipes_unready = Recipe::whereUserId(user()->id)
            ->selectBasic()
            ->approved(0)
            ->latest()
            ->paginate(20)
            ->onEachSide(1);

        return view('users.other.my-recipes', compact('recipes_ready', 'recipes_unready'));
    }

    /**
     * Deactivate user account
     * @param $method this param is there coz its required by Guzzle
     */
    public function destroy($method)
    {
        if (\Hash::check(request()->password, user()->password)) {
            user()->update(['active' => 0]);
            auth()->logout();
            return redirect('/login')->withSuccess(trans('users.account_diactivate'));
        } else {
            return back()->withError(trans('settings.pwd_wrong'));
        }
    }
}
