<?php

namespace App\Http\Responses\Controllers\Recipe;

use App\Models\User;
use App\Models\Recipe;
use App\Repos\MealRepo;
use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var \App\Repos\MealRepo
     */
    private $meal_repo;

    /**
     * @var \App\Models\Recipe|null
     */
    private $recipe;

    /**
     * @var \App\Models\User
     */
    private $user;

    /**
     * @param \App\Models\Recipe|null $recipe
     * @param \App\Repos\MealRepo $meal_repo
     * @param \App\Models\User|null $user
     * @return void
     */
    public function __construct(?Recipe $recipe, MealRepo $meal_repo, ?User $user = null)
    {
        $this->user = $user ?? user();
        $this->recipe = $recipe;
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
    public function recipeIsReadyOrDoesntBelongToThisUser(): bool
    {
        return !$this->user->hasRecipe($this->recipe->id) || $this->recipe->isReady();
    }
}
