<?php

namespace App\Http\Responses\Controllers\Recipes;

use App\Helpers\Traits\RecipeControllerHelpers;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\RedirectResponse;

class StoreResponse implements Responsable
{
    use RecipeControllerHelpers;

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toResponse($request): RedirectResponse
    {
        if ($this->checkForScriptTags($request)) {
            return back()->withError(trans('notifications.cant_use_script_tags'));
        }
        $recipe = $this->createRecipeInDatabase($request->title);
        return redirect("/recipes/{$recipe->slug}/edit");
    }

    /**
     * @param string $title
     * @return \App\Models\Recipe
     */
    protected function createRecipeInDatabase($title): Recipe
    {
        return user()->recipes()->create([
            _('title') => $title,
            'slug' => str_slug($title) . '-' . time(),
        ]);
    }
}
