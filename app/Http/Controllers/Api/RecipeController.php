<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Traits\RecipeControllerHelpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecipesResource;
use App\Models\Recipe;
use App\Models\Visitor;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeController extends Controller
{
    use RecipeControllerHelpers;

    /**
     * @param null|string $hash
     * @return null|object
     */
    public function index(?string $hash = null): ?object
    {
        return RecipesResource::collection($this->makeQueryWithCriteria($hash, 8));
    }

    /**
     * @param string|null $hash
     * @param int|null $pagin
     * @return \Illuminate\Pagination\LenghtAwarePaginator
     */
    public function makeQueryWithCriteria(?string $hash = 'new', ?int $pagin = 8): LengthAwarePaginator
    {
        if ($hash == 'most_liked') {
            return Recipe::withCount('likes')->orderBy('likes_count', 'desc')->done(1)->paginate($pagin);
        }

        if ($hash == 'simple') {
            return Recipe::whereSimple(1)->done(1)->paginate($pagin);
        }

        // Searching for recipes with meal time
        if ($hash == 'breakfast' || $hash == 'lunch' || $hash == 'dinner') {
            return Recipe::with('meal')->whereHas('meal', function ($query) use ($hash) {
                $query->whereNameEn($hash);
            })->done(1)->paginate($pagin);
        }

        if ($hash == 'my_viewes') {
            $result = Recipe::join('views', 'views.recipe_id', '=', 'recipes.id')
                ->where('views.visitor_id', Visitor::whereIp(request()->ip())->value('id'))
                ->orderBy('views.id', 'desc')
                ->done(1)
                ->paginate($pagin);

            $result->map(function ($r) {
                $r->id = $r->recipe_id;
            });

            return $result;
        }

        // Searching for recipes with category
        if (str_contains($hash, 'category=')) {
            return Recipe::whereHas('categories', function ($query) use ($hash) {
                $query->whereId(str_replace('category=', '', $hash));
            })->done(1)->paginate($pagin);
        }
        return Recipe::latest()->done(1)->paginate($pagin);
    }
}
