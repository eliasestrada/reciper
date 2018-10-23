<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use App\Models\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function home()
    {
        try {
            return view('pages.home', [
                'users' => User::inRandomOrder()->limit(50)->get(['id', 'image']),
                'recipes' => Recipe::getRandomUnseen(24, 20),
            ]);
        } catch (QueryException $e) {
            no_connection_error($e, __CLASS__);
            return view('pages.home', [
                'users' => collect(),
                'recipes' => collect(),
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        if (request('for')) {
            $request = mb_strtolower(request('for'));
            $recipes = $this->searchForRecipes($request);

            // Searching for user is for admin only
            if (user() && user()->hasRole('admin') && is_numeric($request)) {
                if (!is_null($result = $this->searchForUser($request))) {
                    return redirect("/users/$result")->withSuccess(trans('users.user_found'));
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
     * @param string $request
     */
    public function searchForRecipes(string $request)
    {
        return Recipe::where('title_' . LANG(), 'LIKE', "%$request%")
            ->orWhere('ingredients_' . LANG(), 'LIKE', "%$request%")
            ->selectBasic()
            ->take(50)
            ->done(1)
            ->paginate(12);
    }

    /**
     * @param string $request
     */
    public function searchForUser(string $request)
    {
        if (!is_null($result = User::whereId($request)->first())) {
            return $result->username;
        }
        return null;
    }
}
