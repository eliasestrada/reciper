<?php

namespace App\Http\Controllers\Resourses;

use App\Repos\VisitorRepo;
use Illuminate\Support\Str;
use App\Repos\RecipeResourceRepo;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecipesResource;
use App\Helpers\Controllers\RecipeHelpers;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeController extends Controller
{
    use RecipeHelpers;

    /**
     * @var \App\Repos\RecipeResourceRepo
     */
    public $recipe_repo;

    /**
     * @var \App\Repos\VisitorRepo
     */
    public $visitor_repo;

    /**
     * @param \App\Repos\RecipeResourceRepo $recipe_repo
     * @param \App\Repos\VisitorRepo $visitor_repo
     * @return void
     */
    public function __construct(RecipeResourceRepo $recipe_repo, VisitorRepo $visitor_repo)
    {
        $this->recipe_repo = $recipe_repo;
        $this->visitor_repo = $visitor_repo;
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
                return $this->recipe_repo->paginateViewedByVisitor(
                    $this->visitor_repo->getVisitorId(), $pagin
                );
                break;

            case Str::contains($hash, 'category='):
                return $this->paginateWithCategoryId((int) $hash, $pagin);
                break;

            case 'new':
            default:
                return $this->recipe_repo->paginateLatest($pagin);
        }
    }
}
