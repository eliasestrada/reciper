<?php

namespace App\Http\Responses\Controllers\Recipes;

use App\Helpers\Traits\RecipeControllerHelpers;
use App\Models\Recipe;
use Illuminate\Contracts\Support\Responsable;

class DestroyResponse implements Responsable
{
    use RecipeControllerHelpers;

    protected $recipe;

    /**
     * @param \App\Models\Recipe $recipe
     * @return void
     */
    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function toResponse($request): string
    {
        if ($this->recipe->user_id !== user()->id) {
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
