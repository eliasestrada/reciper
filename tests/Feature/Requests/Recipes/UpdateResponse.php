<?php

namespace App\Http\Responses\Controllers\Recipes;

use App\Helpers\Controllers\RecipeHelpers;
use App\Models\Recipe;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\RedirectResponse;

class UpdateResponse implements Responsable
{
    use RecipeHelpers;

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toResponse($request): RedirectResponse
    {
        switch (true) {
            case !user()->hasRecipe($this->recipe->id):
                return back()->withError(trans('recipes.cant_draft'));
                break;

            case $this->recipe->isReady():
                return $this->moveToDraftsAndRedirectWithSuccess();
                break;

            case $this->checkForScriptTags($request):
                return back()->withError(trans('notifications.cant_use_script_tags'));
        }

        if ($request->file('image')) {
            $this->dispatchDeleteFileJob($this->recipe->image);
        }

        $filename = $this->saveImageIfExist($request->file('image'), $this->recipe->slug);
        $this->updateRecipe($request, $filename, $this->recipe);

        switch (true) {
            case $this->recipe->isReady() && user()->hasRole('admin'):
                return $this->fireEventAndRedirectWithSuccess();
                break;

            case $this->recipe->isReady():
                return $this->clearCacheAndRedirectWithSuccess();
                break;

            case request()->has('view'):
                return redirect("/recipes/{$this->recipe->slug}");
                break;

            default:
                return redirect("/recipes/{$this->recipe->slug}/edit")
                    ->withSuccess(trans('recipes.saved'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function fireEventAndRedirectWithSuccess(): RedirectResponse
    {
        event(new \App\Events\RecipeGotApproved($this->recipe));

        return redirect('/users/other/my-recipes')
            ->withSuccess(trans('recipes.recipe_published'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function clearCacheAndRedirectWithSuccess(): RedirectResponse
    {
        cache()->forget('unapproved_notif');

        return redirect('/users/other/my-recipes')
            ->withSuccess(trans('recipes.added_to_approving'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function moveToDraftsAndRedirectWithSuccess(): RedirectResponse
    {
        $this->recipe->moveToDrafts();
        $this->clearCache();

        return redirect("/recipes/{$this->recipe->slug}/edit")
            ->withSuccess(trans('recipes.saved'));
    }
}
