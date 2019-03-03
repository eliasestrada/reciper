<?php

namespace App\Http\Responses\Controllers\Admin\Approves;

use App\Repos\Controllers\RecipeRepo;
use Illuminate\Contracts\Support\Responsable;

class IndexResponse implements Responsable
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $recipe_repo = new RecipeRepo;
        $slug = $recipe_repo->getSlugOfTheRecipeThatUserIsChecking(user()->id);

        if ($slug) {
            return redirect("/admin/approves/{$slug}")
                ->withSuccess(trans('approves.finish_checking'));
        }

        return view('admin.approves.index', [
            'recipes' => [
                [
                    'name' => 'unapproved_waiting',
                    'recipes' => $recipe_repo->paginateUnapprovedWaiting(),
                ],
                [
                    'name' => 'unapproved_checking',
                    'recipes' => $recipe_repo->paginateUnapprovedChecking(),
                ],
                [
                    'name' => 'my_approves',
                    'recipes' => $recipe_repo->paginateMyApproves(user()->id),
                ],
            ],
        ]);
    }
}
