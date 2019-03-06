<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\View\View as ViewResponse;
use App\Repos\RecipeRepo;

class PageController extends Controller
{
    /**
     * @throws \Illuminate\Database\QueryException
     * @return \Illuminate\View\View
     */
    public function home(RecipeRepo $recipe_repo): ViewResponse
    {
        try {
            $recipes = $recipe_repo->getRandomUnseen(24);
        } catch (QueryException $e) {
            $recipes = report_error($e, collect());
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
     * @throws \Illuminate\Database\QueryException
     * @param string $request
     * @return Illuminate\Pagination\LengthAwarePaginator or void
     */
    public function searchForRecipes(string $request)
    {
        try {
            return Recipe::where(_('title'), 'LIKE', "%$request%")
                ->orWhere(_('ingredients'), 'LIKE', "%$request%")
                ->take(50)
                ->done(1)
                ->paginate(12);
        } catch (QueryException $e) {
            return report_error($e);
        }
    }

    /**
     * Helper that searches for user by user id
     *
     * @throws \Illuminate\Database\QueryException
     * @param string $request
     * @return string|null
     */
    public function searchForUser(string $request): ?string
    {
        try {
            $result = User::whereId($request)->first();
        } catch (QueryException $e) {
            $result = report_error($e);
        }

        return $result ?? $result->username;
    }
}
