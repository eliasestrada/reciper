<?php

namespace App\Http\Responses\Controllers\Recipe;

use App\Models\Recipe;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use App\Helpers\Controllers\RecipeHelpers;
use Illuminate\Contracts\Support\Responsable;

class StoreResponse implements Responsable
{
    use RecipeHelpers;

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toResponse($request): RedirectResponse
    {
        if ($this->checkForScriptTags($request->except(['_token']))) {
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
            'slug' => Str::slug($title) . '-' . time(),
        ]);
    }
}
