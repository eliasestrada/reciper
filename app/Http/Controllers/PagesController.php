<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Title;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function home()
    {
        $random_recipes = Recipe::inRandomOrder()
            ->where("ready_" . lang(), 1)
            ->where("approved_" . lang(), 1)
            ->limit(12)
            ->get([
                'id', 'title_' . lang(),
                "intro_" . lang(), 'image',
            ]);

        $title_intro = cache()->rememberForever('title_intro', function () {
            return Title::whereName("intro")->first([
                'title_' . lang(),
                'text_' . lang(),
            ]);
        });

        return view('pages.home', compact('random_recipes', 'title_intro'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $recipes = collect();
        $message = trans('pages.use_search');

        if (request('for')) {
            $request = mb_strtolower(request('for'));

            $recipes = Recipe::where('title_' . lang(), 'LIKE', "%$request%")
                ->orWhere('ingredients_' . lang(), 'LIKE', "%$request%")
                ->take(50)
                ->done(1)
                ->paginate(12);

            $message = $recipes->count() == 0 ? trans('pages.nothing_found') : '';
        }

        $search_suggest = cache()->rememberForever('search_suggest', function () {
            return Recipe::query()->done(1)->pluck('title_' . lang())->toArray();
        });

        return view('pages.search', compact(
            'recipes', 'search_suggest', 'message'
        ));
    }
}
