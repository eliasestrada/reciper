<?php

namespace App\Http\Controllers;

use Illuminate\View\View as ViewResponse;
use App\Repos\RecipeRepo;
use App\Repos\MealRepo;
use App\Repos\FavRepo;
use App\Models\Recipe;
use App\Http\Responses\Controllers\Recipes\UpdateResponse;
use App\Http\Responses\Controllers\Recipes\StoreResponse;
use App\Http\Responses\Controllers\Recipes\ShowResponse;
use App\Http\Responses\Controllers\Recipes\EditResponse;
use App\Http\Responses\Controllers\Recipes\DestroyResponse;
use App\Http\Requests\Recipes\RecipeUpdateRequest;
use App\Http\Requests\Recipes\RecipeStoreRequest;

class RecipeController extends Controller
{
    /**
     * @var \App\Repos\RecipeRepo $repo
     */
    private $repo;

    /**
     * @param \App\Repos\RecipeRepo $repo
     * @return void
     */
    public function __construct(RecipeRepo $repo)
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->repo = $repo;
    }

    /**
     * @param \App\Repos\FavRepo
     * @return \Illuminate\View\View
     */
    public function index(FavRepo $favs): ViewResponse
    {
        return view('recipes.index', ['favs' => $favs->all()]);
    }

    /**
     * It will save the recipe to a database with title only
     *
     * @param \App\Http\Requests\Recipes\RecipeStoreRequest $request
     * @return \App\Http\Responses\Controllers\Recipes\StoreResponse
     */
    public function store(RecipeStoreRequest $request): StoreResponse
    {
        return new StoreResponse;
    }

    /**
     * It will show the recipe on a single page
     *
     * @param string $slug
     * @return \App\Http\Responses\Controllers\Recipes\ShowResponse
     */
    public function show(string $slug): ShowResponse
    {
        return new ShowResponse($slug);
    }

    /**
     * @param string $slug
     * @param \App\Repos\MealRepo $meal_repo
     * @return \App\Http\Responses\Controllers\Recipes\EditResponse
     */
    public function edit(string $slug, MealRepo $meal_repo): EditResponse
    {
        return new EditResponse($slug, $this->repo, $meal_repo);
    }

    /**
     * Update single recipe
     * This method triggers event RecipeIsReady
     *
     * @param \App\Http\Requests\Recipes\RecipeUpdateRequest $request
     * @param \App\Models\Recipe $recipe
     * @return \App\Http\Responses\Controllers\Recipes\UpdateResponse
     */
    public function update(RecipeUpdateRequest $request, Recipe $recipe)
    {
        return new UpdateResponse($recipe);
    }

    /**
     * Delete recipe form database
     *
     * @param \App\Models\Recipe $recipe
     * @return \App\Http\Responses\Controllers\Recipes\DestroyResponse
     */
    public function destroy(Recipe $recipe): DestroyResponse
    {
        return new DestroyResponse($recipe);
    }
}
