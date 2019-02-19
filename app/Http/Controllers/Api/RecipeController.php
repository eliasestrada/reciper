<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Controllers\RecipeHelpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecipesResource;
use App\Models\Recipe;
use App\Models\Visitor;
use App\Repos\RecipeRepo;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeController extends Controller
{
    use RecipeHelpers;

    /**
     * @var \App\Repos\RecipeRepo
     */
    protected $recipe_repo;

    /**
     * @param \App\Repos\RecipeRepo $recipe_repo
     */
    public function __construct(RecipeRepo $recipe_repo)
    {
        $this->recipe_repo = $recipe_repo;
    }

    /**
     * @param null|string $hash
     * @return null|object
     */
    public function index(?string $hash = null): ?object
    {
        return RecipesResource::collection($this->makeQueryWithCriteria($hash));
    }

    /**
     * @param string|null $hash
     * @return \Illuminate\Pagination\LenghtAwarePaginator
     */
    public function makeQueryWithCriteria(?string $hash): LengthAwarePaginator
    {
        switch ($hash ?? 'new') {
            case 'most_liked':
                return $this->recipe_repo->paginateByLikes();
                break;

            case 'simple':
                return $this->recipe_repo->paginateAllSimple();
                break;

            case 'breakfast':
            case 'lunch':
            case 'dinner':
                // Searching for recipes with meal time
                return Recipe::with('meal')->whereHas('meal', function ($query) use ($hash) {
                    $query->whereNameEn($hash);
                })->done(1)->paginate(8);
                break;

            case 'my_views':
                $result = Recipe::join('views', 'views.recipe_id', '=', 'recipes.id')
                    ->where('views.visitor_id', Visitor::whereIp(request()->ip())->value('id'))
                    ->orderBy('views.id', 'desc')
                    ->done(1)
                    ->paginate(8);

                $result->map(function ($r) {
                    $r->id = $r->recipe_id;
                });

                return $result;
                break;

            case str_contains($hash, 'category='):
                // Searching for recipes with category
                return Recipe::whereHas('categories', function ($query) use ($hash) {
                    $query->whereId(str_replace('category=', '', $hash));
                })->done(1)->paginate(8);
                break;

            case 'new':
                return Recipe::latest()->done(1)->paginate(8);
        }
    }
}
