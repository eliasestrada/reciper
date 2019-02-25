<?php

namespace App\Http\Responses\Controllers\Recipes;

use Illuminate\Contracts\Support\Responsable;
use App\Repos\RecipeRepo;
use App\Repos\MealRepo;
use App\Models\User;

class EditResponse implements Responsable
{
    /**
     * @var \App\Repos\MealRepo $meal_repo
     */
    private $meal_repo;

    /**
     * @var \App\Models\Recipe $recipe
     */
    private $recipe;

    /**
     * @var \App\Models\User $user
     */
    private $user;

    /**
     * @param string $slug
     * @param \App\Repos\RecipeRepo $recipe_repo
     * @param \App\Repos\MealRepo $meal_repo
     * @param \App\Models\User|null $user
     * @return void
     */
    public function __construct(string $slug, RecipeRepo $recipe_repo, MealRepo $meal_repo, ?User $user = null)
    {
        $this->user = $user ?? user();
        $this->recipe = $recipe_repo->find($slug);
        $this->meal_repo = $meal_repo;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function toResponse($request)
    {
        if ($this->recipeIsReadyOrDoesntBelongToThisUser()) {
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
    protected function recipeIsReadyOrDoesntBelongToThisUser(): bool
    {
        return !$this->user->hasRecipe($this->recipe->id) || $this->recipe->isReady();
    }
}
