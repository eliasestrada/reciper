<?php

namespace App\Http\Responses\Controllers\Admin\Approves;

use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Responsable;
use App\Helpers\Controllers\Admin\ApproveHelpers;

class DisapproveResponse implements Responsable
{
    use ApproveHelpers;

    /**
     * @param \App\Models\Recipe|null
     */
    private $recipe;

    /**
     * @param \App\Models\Recipe|null $recipe
     * @return void
     */
    public function __construct(?Recipe $recipe)
    {
        $this->recipe = $recipe;
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
