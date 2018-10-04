<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use App\Models\View;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function home()
    {
        return view('pages.home', ['recipes' => Recipe::getRandomUnseen(24, 12)]);
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
                if ($this->searchForUser($request)) {
                    return redirect("/users/$request")->withSuccess(trans('users.user_found'));
                } else {
                    return back()->withError(trans('users.user_not_found'));
                }
            }

            $message = $recipes->count() == 0 ? trans('pages.nothing_found') : '';
        } else {
            $recipes = collect();
            $message = trans('pages.use_search');
        }

        $search_suggest = $this->searchForSuggestions();

        return view('pages.search', compact('recipes', 'search_suggest', 'message'));
    }

    /**
     * @param string $request
     */
    public function searchForRecipes(string $request)
    {
        return Recipe::where('title_' . lang(), 'LIKE', "%$request%")
            ->orWhere('ingredients_' . lang(), 'LIKE', "%$request%")
            ->selectBasic()
            ->take(50)
            ->done(1)
            ->paginate(12);
    }

    /**
     * @param string $request
     * @return void
     */
    public function searchForUser(string $request)
    {
        if (User::whereId($request)->exists()) {
            return true;
        }
        return false;
    }

    public function searchForSuggestions()
    {
        return cache()->remember('search_suggest', config('cache.search_suggest'), function () {
            return Recipe::query()->done(1)->pluck('title_' . lang())->toArray();
        });
    }
}
