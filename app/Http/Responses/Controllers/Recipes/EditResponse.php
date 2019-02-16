<?php

namespace App\Http\Responses\Controllers\Recipes;

use App\Models\Recipe;
use App\Repos\MealRepo;
use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    protected $recipe;
    protected $meal_repo;

    /**
     * @param string $slug
     * @param \App\Repos\MealRepo $meal_repo
     * @return void
     */
    public function __construct(string $slug, MealRepo $meal_repo)
    {
        $this->recipe = Recipe::whereSlug($slug)->first();
        $this->meal_repo = $meal_repo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function toResponse($request)
    {
        if ($this->recipeIsNotReadyOrDoesntBelongToThisUser()) {
            return redirect('/recipes')->withError(
                trans('recipes.cant_edit_ready_recipe')
            );
        }

        return view('recipes.edit', [
            'recipe' => $this->recipe,
            'meal' => $this->meal_repo->getWithCache(),
        ]);
    }

    /**
     * @return bool
     */
    protected function recipeIsNotReadyOrDoesntBelongToThisUser(): bool
    {
        return !user()->hasRecipe($this->recipe->id) || $this->recipe->isReady();
    }
}
