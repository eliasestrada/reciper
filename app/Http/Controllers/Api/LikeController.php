<?php

namespace App\Http\Controllers\Api;

use App\Repos\UserRepo;
use App\Repos\RecipeRepo;
use App\Models\Popularity;
use App\Http\Controllers\Controller;
use App\Http\Responses\Controllers\Api\Like\StoreResponse;

class LikeController extends Controller
{
    /**
     * @var \App\Repos\RecipeRepo
     */
    private $recipe_repo;

    /**
     * @var \App\Repos\UserRepo
     */
    private $user_repo;

    /**
     * @param \App\Repos\RecipeRepo $recipe_repo
     * @param \App\Repos\UserRepo $user_repo
     * @return void
     */
    public function __construct(RecipeRepo $recipe_repo, UserRepo $user_repo)
    {
        $this->middleware('auth');
        $this->recipe_repo = $recipe_repo;
        $this->user_repo = $user_repo;
    }

    /**
     * Add like to particular recipe
     *
     * @param string $slug
     * @param \App\Models\Popularity $popularity
     * @return \App\Http\Responses\Controllers\Api\Like\StoreResponse
     */
    public function store(string $slug, Popularity $popularity): StoreResponse
    {
        $recipe = $this->recipe_repo->find($slug);
        $recipe_author = $this->user_repo->find($recipe->user_id);

        return new StoreResponse($recipe, $popularity->takeUser($recipe_author));
    }
}
