<?php

namespace App\Http\Controllers;

use App\Models\Xp;
use App\Models\Recipe;
use App\Repos\UserRepo;
use App\Repos\RecipeRepo;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Responses\Controllers\User\ShowResponse;

class UserController extends Controller
{
    /**
     * @var \App\Repos\UserRepo
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
     * @param \App\Repos\RecipeRepo $recipe_repo
     * @param \App\Models\Xp $xp
     * @return \App\Http\Responses\Controllers\User\ShowResponse
     */
    public function show(string $username, RecipeRepo $recipe_repo, Xp $xp): ShowResponse
    {
        return new ShowResponse($this->repo->find($username), $recipe_repo, $xp);
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
