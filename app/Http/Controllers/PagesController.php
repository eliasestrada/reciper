<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use App\Models\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\View\View as ViewResponse;

class PagesController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function home(): ViewResponse
    {
        try {
            $recipes = Recipe::getRandomUnseen(24, 20);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            $recipes = [];
        }
        return view('pages.home', compact('recipes'));
    }

    /**
     * Show search page
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        if (request('for')) {
            $request = mb_strtolower(request('for'));
            $recipes = $this->searchForRecipes($request);

            // Searching for user is for admin only
            if (user() && user()->hasRole('admin') && is_numeric($request)) {
                if (!is_null($result = $this->searchForUser($request))) {
                    return redirect("/users/{$result}")->withSuccess(trans('users.user_found'));
                } else {
                    return back()->withError(trans('users.user_not_found'));
                }
            }

            $message = $recipes->count() == 0 ? trans('pages.nothing_found') : '';
        } else {
            $recipes = collect();
            $message = trans('pages.use_search');
        }

        return view('pages.search', compact('recipes', 'message'));
    }

    /**
     * Helper that searches for recipes
     *
     * @param string $request
     * @return Illuminate\Pagination\LengthAwarePaginator or void
     */
    public function searchForRecipes(string $request)
    {
        try {
            return Recipe::where('title_' . LANG(), 'LIKE', "%$request%")
                ->orWhere('ingredients_' . LANG(), 'LIKE', "%$request%")
                ->selectBasic()
                ->take(50)
                ->done(1)
                ->paginate(12);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
        }
    }

    /**
     * Helper that searches for user by user id
     *
     * @param string $request
     * @return string|null
     */
    public function searchForUser(string $request): ?string
    {
        try {
            $result = User::whereId($request)->first();
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
        }

        return is_null($result) ? null : $result->username;
    }
}
