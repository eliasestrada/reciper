<?php

namespace App\Http\Responses\Controllers;

use App\Models\Recipe;
use Illuminate\Contracts\Support\Responsable;

class RecipeUpdateResponse implements Responsable
{
    protected $recipe;

    /**
     * @param \App\Models\Recipe $recipe
     * @return void
     */
    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * @param $request
     */
    public function toResponse($request)
    {
        if ($this->recipe->isReady() && user()->hasRole('admin')) {
            event(new \App\Events\RecipeGotApproved($this->recipe));

            return redirect('/users/other/my-recipes')->withSuccess(
                trans('recipes.recipe_published')
            );
        }

        if ($this->recipe->isReady()) {
            cache()->forget('unapproved_notif');

            return redirect('/users/other/my-recipes')->withSuccess(
                trans('recipes.added_to_approving')
            );
        }

        if (request()->has('view')) {
            return redirect("/recipes/{$this->recipe->slug}");
        }

        return redirect("/recipes/{$this->recipe->slug}/edit")->withSuccess(
            trans('recipes.saved')
        );
    }
}
