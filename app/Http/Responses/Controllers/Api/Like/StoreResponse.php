<?php

namespace App\Http\Responses\Controllers\Api\Like;

use App\Models\Recipe;
use App\Models\Popularity;
use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Responsable;

class StoreResponse implements Responsable
{
    /**
     * @var \App\Models\Recipe
     */
    private $recipe;

    /**
     * @var \App\Models\Popularity
     */
    private $popularity;

    /**
     * @param \App\Models\Recipe $recipe
     * @param \App\Models\Popularity $popularity
     * @return void
     */
    public function __construct(Recipe $recipe, Popularity $popularity)
    {
        $this->recipe = $recipe;
        $this->popularity = $popularity;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|null
     */
    public function toResponse($request): ?Response
    {
        return $this->authUserAlreadyLikedTheRecipe()
            ? $this->removeLikeAndPopularityPoints()
            : $this->addLikeAndPopularityPoints();
    }

    /**
     * @return bool
     */
    public function authUserAlreadyLikedTheRecipe(): bool
    {
        return user()->likes()->whereRecipeId($this->recipe->id)->exists();
    }

    /**
     * @return null
     */
    public function removeLikeAndPopularityPoints()
    {
        user()->likes()->whereRecipeId($this->recipe->id)->delete();
        $this->popularity->remove(config('custom.popularity_for_like'));
        return null;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function addLikeAndPopularityPoints(): Response
    {
        user()->likes()->create(['recipe_id' => $this->recipe->id]);
        $this->popularity->add(config('custom.popularity_for_like'));
        return response('active');
    }
}
