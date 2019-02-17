<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisapproveRequest;
use App\Http\Responses\Controllers\Admin\Approves\ShowResponse;
use App\Models\Recipe;
use App\Repos\RecipeRepo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApproveController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Shows all recipes that need to be approved
     * by administration
     *
     * @return mixed
     */
    public function index(RecipeRepo $recipe_repo)
    {
        $already_checking = $recipe_repo->getIdOfTheRecipeThatUserIsChecking();

        if ($already_checking) {
            return redirect("/admin/approves/{$already_checking}")
                ->withSuccess(trans('approves.finish_checking'));
        }

        return view('admin.approves.index', [
            'recipes' => [
                1 => [
                    'name' => 'unapproved_waiting',
                    'recipes' => $recipe_repo->paginateUnapprovedWaiting(),
                ],
                2 => [
                    'name' => 'unapproved_checking',
                    'recipes' => $recipe_repo->paginateUnapprovedChecking(),
                ],
                3 => [
                    'name' => 'my_approves',
                    'recipes' => $recipe_repo->paginateMyApproves(),
                ],
            ],
        ]);
    }

    /**
     * Show single recipe
     *
     * @param \App\Models\Recipe $recipe
     * @return \App\Http\Responses\Controllers\Admin\Approves\ShowResponse
     */
    public function show(Recipe $recipe): ShowResponse
    {
        return new ShowResponse($recipe);
    }

    /**
     * x-recipe-approved header is asserted by tests
     *
     * @param \App\Models\Recipe $recipe
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Recipe $recipe): RedirectResponse
    {
        $error_message = $this->returnErrorIfApprovedOrNotReady($recipe);

        if (!is_null($error_message)) {
            return redirect("/admin/approves")->withError($error_message);
        }

        event(new \App\Events\RecipeGotApproved($recipe));

        $recipe->update([_('approved') => 1]);
        cache()->forget('unapproved_notif');

        return redirect("/recipes/$recipe->slug")
            ->header('x-recipe-approved', 1)
            ->withSuccess(trans('recipes.recipe_published'));
    }

    /**
     * x-recipe-disapproved header is asserted by tests
     *
     * @param \App\Models\Recipe $recipe
     * @param \App\Http\Requests\DisapproveRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disapprove(Recipe $recipe, DisapproveRequest $request): RedirectResponse
    {
        $error_message = $this->returnErrorIfApprovedOrNotReady($recipe);

        if (!is_null($error_message)) {
            return redirect("/admin/approves")->withError($error_message);
        }

        event(new \App\Events\RecipeGotCanceled($recipe, $request->message));

        $recipe->update([_('ready') => 0]);
        cache()->forget('unapproved_notif');

        return redirect('/recipes#new')
            ->header('x-recipe-disapproved', 1)
            ->withSuccess(trans('recipes.you_gave_recipe_back_on_editing'));
    }

    /**
     * Helper function
     *
     * @param \App\Models\Recipe $recipe
     */
    public function returnErrorIfApprovedOrNotReady(Recipe $recipe)
    {
        if ($recipe->isDone()) {
            return trans('approves.already_approved');
        }

        if (!$recipe->isReady() && !$recipe->isApproved()) {
            return trans('recipes.not_written');
        }
        return null;
    }
}
