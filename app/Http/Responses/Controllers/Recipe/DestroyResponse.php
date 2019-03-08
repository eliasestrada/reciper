<?php

namespace App\Http\Responses\Controllers\Recipe;

use App\Repos\RecipeRepo;
use App\Helpers\Controllers\RecipeHelpers;
use Illuminate\Contracts\Support\Responsable;

class DestroyResponse implements Responsable
{
    use RecipeHelpers;

    protected $recipe;

    /**
     * @param string $slug
     * @param \App\Repos\RecipeRepo $repo
     * @return void
     */
    public function __construct(string $slug, RecipeRepo $repo)
    {
        $this->recipe = $repo->find($slug);
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
