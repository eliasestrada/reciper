<?php

namespace App\Http\Responses\Controllers\Recipes;

use App\Models\Xp;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Popularity;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Responsable;

class ShowResponse implements Responsable
{
    protected $recipe;

    /**
     * @param string $slug
     * @return void
     */
    public function __construct(string $slug)
    {
        $this->recipe = Recipe::with('user:id,username,photo,name,xp')
            ->whereSlug($slug)
            ->first();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function toResponse($request)
    {
        if ($this->guestAndRecipeIsNotDone()) {
            return redirect('/recipes')->withError(trans('recipes.no_rights_to_see'));
        }

        if ($this->userNotOwnerAndRecipeIsNotReady()) {
            return redirect('/recipes')->withError(trans('recipes.not_written'));
        }

        if ($this->userNotOwnerAndRecipeIsNotApproved()) {
            return redirect('/recipes')->withError(trans('recipes.not_approved'));
        }

        $this->handlePopularityAndViews();

        return view('recipes.show', [
            'recipe' => $this->recipe,
            'xp' => $this->recipe->user ? new Xp($this->recipe->user) : [],
            'cookie' => getCookie('r_font_size') ?? '1.0',
        ]);
    }

    /**
     *  Mark that visitor saw the recipe if he didn't
     *  Else increment visits column by one
     *
     * @return void
     */
    protected function handlePopularityAndViews(): void
    {
        if ($this->recipe->views()->whereVisitorId(visitor_id())->doesntExist()) {
            try {
                $this->recipe->views()->create(['visitor_id' => visitor_id()]);
                if ($this->recipe->user_id) {
                    $popularity = new Popularity(User::find($this->recipe->user_id));
                    $popularity->add(config('custom.popularity_for_view'));
                }
            } catch (QueryException $e) {
                // do nothing
            }
        } else {
            $this->recipe->views()->whereVisitorId(visitor_id())->increment('visits');
        }
    }

    /**
     * @return bool
     */
    protected function userNotOwnerAndRecipeIsNotReady(): bool
    {
        return user() && !user()->hasRecipe($this->recipe->id) && !$this->recipe->isReady();
    }

    /**
     * @return bool
     */
    protected function userNotOwnerAndRecipeIsNotApproved(): bool
    {
        return user() && !user()->hasRecipe($this->recipe->id) && !$this->recipe->isApproved();
    }

    /**
     * @return bool
     */
    protected function guestAndRecipeIsNotDone(): bool
    {
        return !user() && !$this->recipe->isDone();
    }
}
