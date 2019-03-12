<?php

namespace App\Http\Responses\Controllers\Admin\Approves;

use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Responsable;
use App\Helpers\Controllers\Admin\ApproveHelpers;

class ApproveResponse implements Responsable
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

        event(new \App\Events\RecipeGotApproved($this->recipe));

        $this->recipe->update([_('approved') => 1]);
        cache()->forget('unapproved_notif');

        return redirect("/recipes/{$this->recipe->slug}")
            ->header('x-recipe-approved', 1)
            ->withSuccess(trans('recipes.recipe_published'));
    }
}
