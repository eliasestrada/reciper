<?php

namespace App\Http\Controllers;

use App\Models\Xp;
use App\Models\User;
use App\Models\Recipe;
use App\Repos\UserRepo;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * @var \App\Repos\UserRepo $repo
     */
    private $repo;

    /**
     * @param \App\Repos\UserRepo $repo
     * @return void
     */
    public function __construct(UserRepo $repo)
    {
        $this->middleware('auth')->except(['index', 'show', 'store']);
        $this->repo = $repo;
    }

    /**
     * Show all users
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('users.index', [
            'users' => $this->repo->paginateActiveUsers(36)
        ]);
    }

    /**
     * @param string $username
     * @return mixed
     */
    public function show(string $username)
    {
        $user = User::whereUsername($username)->first();

        if (!$user) {
            return redirect('/users')->withError(trans('users.user_not_found'));
        }

        $recipes = Recipe::whereUserId($user->id)
            ->withCount('likes')
            ->withCount('views')
            ->withCount('favs')
            ->done(1)
            ->latest()
            ->paginate(20)
            ->onEachSide(1);

        $xp = new Xp($user);
        $max_xp_for_current_level = $xp->maxXpForCurrentLevel() + 1;
        $level_higher_than_max = $xp->minXpForCurrentLevel() >= config('custom.max_xp');
        $max_xp = $level_higher_than_max ? '' : "/ {$max_xp_for_current_level}";

        return view('users.show', compact('recipes', 'user', 'xp', 'max_xp'));
    }

    /**
     * Recover users' account
     *
     * @param \Illuminate\Http\RedirectResponse
     */
    public function store(): RedirectResponse
    {
        user()->update(['active' => 1]);

        return redirect('/users/' . user()->username)->withSuccess(
            trans('users.account_recovered')
        );
    }

    /**
     * @return \Illuminate\View\View
     */
    public function my_recipes(): View
    {
        $recipes_ready = Recipe::whereUserId(user()->id)
            ->done(1)
            ->latest()
            ->paginate(20)
            ->onEachSide(1);

        $recipes_unready = Recipe::whereUserId(user()->id)
            ->approved(0)
            ->latest()
            ->paginate(20)
            ->onEachSide(1);

        return view('users.other.my-recipes', compact(
            'recipes_ready', 'recipes_unready'
        ));
    }

    /**
     * Deactivate user account
     *
     * @param $method this param is there coz its required by Guzzle
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($method): RedirectResponse
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
