<?php

namespace App\Http\Controllers\Resourses;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Repos\RecipeRepo;
use App\Models\Visitor;
use App\Models\Recipe;
use App\Http\Resources\RecipesResource;
use App\Http\Controllers\Controller;
use App\Helpers\Controllers\RecipeHelpers;

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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|null
     */
    public function index(?string $hash = null)
    {
        return RecipesResource::collection($this->makeQueryWithCriteria($hash, 8));
    }

    /**
     * @param string|null $hash Url hash
     * @param int $pagin Pagination value
     * @return \Illuminate\Pagination\LenghtAwarePaginator|null
     */
    public function makeQueryWithCriteria(?string $hash, int $pagin): ?LengthAwarePaginator
    {
        switch ($hash ?? 'new') {
            case 'most_liked':
                return $this->recipe_repo->paginateByLikes($pagin);
                break;

            case 'simple':
                return $this->recipe_repo->paginateAllSimple($pagin);
                break;

            case 'breakfast':
            case 'lunch':
            case 'dinner':
                return $this->recipe_repo->paginateWithMealTime($hash, $pagin);
                break;

            case 'my_views':
                $visitor_id = Visitor::whereIp(request()->ip())->value('id');
                return $this->recipe_repo->paginateViewedByVisitor($visitor_id);
                break;

            case str_contains($hash, 'category='):
                // Searching for recipes with category
                return Recipe::whereHas('categories', function ($query) use ($hash) {
                    $query->whereId(str_replace('category=', '', $hash));
                })->done(1)->paginate($pagin);
                break;

            case 'new':
                return $this->recipe_repo->paginateLatest($pagin);
        }
    }
}
