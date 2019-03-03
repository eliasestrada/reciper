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
        $already_checking = $recipe_repo->getIdOfTheRecipeThatUserIsChecking(user()->id);

        if ($already_checking) {
            return redirect("/admin/approves/{$already_checking}")
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
