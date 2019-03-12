<?php

namespace App\Http\Responses\Controllers\User;

use App\Models\Xp;
use App\Models\User;
use App\Repos\UserRepo;
use App\Repos\RecipeRepo;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Responsable;

class ShowResponse implements Responsable
{
    /**
     * @var \App\Repos\RecipeRepo
     */
    private $recipe_repo;

    /**
     * @var \App\Models\Xp
     */
    private $xp;

    /**
     * @var \App\Models\User|null
     */
    private $user;

    /**
     * @param \App\Models\User|null $user
     * @param \App\Repos\RecipeRepo $recipe_repo
     * @param \App\Models\Xp $xp
     * @return void
     */
    public function __construct(?User $user, RecipeRepo $recipe_repo, Xp $xp)
    {
        $this->user = $user;
        $this->recipe_repo = $recipe_repo;
        $this->xp = $xp;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function toResponse($request)
    {
        if (!$this->user) {
            return redirect('/users')->withError(trans('users.user_not_found'));
        }

        $recipes = $this->recipe_repo->paginateUserRecipesWithCountColumns($this->user->id, [
            'likes', 'views', 'favs'
        ]);

        $this->xp->takeUser($this->user);
        $max_xp_for_current_level = $this->xp->maxXpForCurrentLevel() + 1;
        $level_higher_than_max = $this->xp->minXpForCurrentLevel() >= config('custom.max_xp');

        return view('users.show', [
            'recipes' => $recipes,
            'max_xp' => $level_higher_than_max ? '' : "/ {$max_xp_for_current_level}",
            'user' => $this->user,
            'xp' => $this->xp,
        ]);
    }
}
