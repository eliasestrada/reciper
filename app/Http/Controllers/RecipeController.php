<?php

namespace App\Http\Controllers;

use App\Models\Xp;
use App\Models\Recipe;
use App\Repos\FavRepo;
use App\Repos\MealRepo;
use App\Repos\RecipeRepo;
use App\Models\Popularity;
use Illuminate\View\View as ViewResponse;
use App\Http\Requests\Recipes\RecipeStoreRequest;
use App\Http\Requests\Recipes\RecipeUpdateRequest;
use App\Http\Responses\Controllers\Recipe\EditResponse;
use App\Http\Responses\Controllers\Recipe\ShowResponse;
use App\Http\Responses\Controllers\Recipe\StoreResponse;
use App\Http\Responses\Controllers\Recipe\UpdateResponse;
use App\Http\Responses\Controllers\Recipe\DestroyResponse;

class RecipeController extends Controller
{
    /**
     * @var \App\Repos\RecipeRepo
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
     * @return \App\Http\Responses\Controllers\Recipe\StoreResponse
     */
    public function store(RecipeStoreRequest $request): StoreResponse
    {
        return new StoreResponse;
    }

    /**
     * It will show the recipe on a single page
     *
     * @param string $slug
     * @param \App\Models\Xp $xp
     * @param \App\Models\Popularity $popularity
     * @return \App\Http\Responses\Controllers\Recipe\ShowResponse
     */
    public function show(string $slug, Xp $xp, Popularity $popularity): ShowResponse
    {
        return new ShowResponse($slug, $this->repo, $xp, $popularity);
    }

    /**
     * @param string $slug
     * @param \App\Repos\MealRepo $meal_repo
     * @return \App\Http\Responses\Controllers\Recipe\EditResponse
     */
    public function edit(string $slug, MealRepo $meal_repo): EditResponse
    {
        return new EditResponse($slug, $this->repo, $meal_repo);
    }

    /**
     * Update single recipe
     *
     * @param \App\Http\Requests\Recipes\RecipeUpdateRequest $request
     * @param string $slug
     * @return \App\Http\Responses\Controllers\Recipe\UpdateResponse
     */
    public function update(RecipeUpdateRequest $request, string $slug): UpdateResponse
    {
        return new UpdateResponse($slug, $this->repo);
    }

    /**
     * Delete recipe form database
     *
     * @param string $slug
     * @return \App\Http\Responses\Controllers\Recipe\DestroyResponse
     */
    public function destroy(string $slug): DestroyResponse
    {
        return new DestroyResponse($slug, $this->repo);
    }
}
