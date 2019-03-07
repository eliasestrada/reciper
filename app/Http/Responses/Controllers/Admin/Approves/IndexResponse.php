<?php

namespace App\Http\Responses\Controllers\Admin\Approves;

use App\Repos\RecipeRepo;
use Illuminate\Contracts\Support\Responsable;

class IndexResponse implements Responsable
{
    /**
     * @var \App\Repos\RecipeRepo $recipe_repo
     */
    private $recipe_repo;

    /**
     * @var \App\Models\User $user
     */
    private $user;

    /**
     * @param \App\Repos\RecipeRepo $recipe_repo
     * @param \App\Models\User $user
     * @return void
     */
    public function __construct(RecipeRepo $recipe_repo, ?User $user = null)
    {
        $this->recipe_repo = $recipe_repo;
        $this->user = $user ?? user();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $slug = $this->recipe_repo->getRecipeSlugThatAdminIsChecking($this->user->id);

        if ($slug) {
            return redirect("/admin/approves/{$slug}")
                ->withSuccess(trans('approves.finish_checking'));
        }

        return view('admin.approves.index', [
            'recipes' => $this->getRecipesArray(),
        ]);
    }

    /**
     * @return array
     */
    public function getRecipesArray(): array
    {
        return [
            [
                'name' => 'unapproved_waiting',
                'recipes' => $this->recipe_repo->paginateUnapprovedWaiting(),
            ],
            [
                'name' => 'unapproved_checking',
                'recipes' => $this->recipe_repo->paginateUnapprovedChecking(),
            ],
            [
                'name' => 'my_approves',
                'recipes' => $this->recipe_repo->paginateMyApproves(user()->id),
            ],
        ];
    }
}
