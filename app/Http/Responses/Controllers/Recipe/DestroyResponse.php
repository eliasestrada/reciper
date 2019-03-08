<?php

namespace App\Http\Responses\Controllers\Recipe;

use App\Models\Recipe;
use App\Helpers\Controllers\RecipeHelpers;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Auth\User;

class DestroyResponse implements Responsable
{
    use RecipeHelpers;

    /**
     * @var \App\Models\Recipe
     */
    private $recipe;

    /**
     * @var \App\Models\User|null
     */
    private $user;

    /**
     * @param \App\Models\Recipe $recipe
     * @param \App\Models\User|null $user
     * @return void
     */
    public function __construct(Recipe $recipe, ?User $user = null)
    {
        $this->recipe = $recipe;
        $this->user = $user ?? user();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function toResponse($request): string
    {
        if ($this->recipe->user_id !== $this->user->id) {
            return 'failed';
        }

        $this->dispatchDeleteFileJob($this->recipe->image);
        $this->deleteRelationships();
        $this->clearCache();

        return $this->recipe->delete() ? 'success' : 'failed';
    }

    /**
     * @return void
     */
    protected function deleteRelationships(): void
    {
        $this->recipe->categories()->detach();
        $this->recipe->likes()->delete();
        $this->recipe->views()->delete();
        $this->recipe->favs()->delete();
    }
}
