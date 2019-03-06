<?php

namespace App\Http\Responses\Controllers\Admin\Approves;

use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Responsable;
use App\Helpers\Controllers\Admin\ApproveHelpers;
use App\Repos\RecipeRepo;

class DisapproveResponse implements Responsable
{
    use ApproveHelpers;

    protected $recipe;

    /**
     * @param string $slug
     * @param \App\Repos\RecipeRepo $recipe_repo
     * @return void
     */
    public function __construct(string $slug, RecipeRepo $recipe_repo)
    {
        $this->recipe = $recipe_repo->find($slug);
    }

    /**
     * x-recipe-approved header is asserted by tests and needed
     * just for testing purposes
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toResponse($request): RedirectResponse
    {
        $error_message = $this->returnErrorIfApprovedOrNotReady($this->recipe);

        if (!is_null($error_message)) {
            return redirect("/admin/approves")->withError($error_message);
        }

        event(new \App\Events\RecipeGotCanceled($this->recipe, $request->message));

        $this->recipe->update([_('ready') => 0]);
        cache()->forget('unapproved_notif');

        return redirect('/recipes#new')
            ->header('x-recipe-disapproved', 1)
            ->withSuccess(trans('recipes.you_gave_recipe_back_on_editing'));
    }
}
