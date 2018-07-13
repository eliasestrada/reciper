<?php

namespace App\Http\Responses\Controllers;

use App\Models\Recipe;
use App\Events\RecipeIsReady;
use Illuminate\Contracts\Support\Responsable;

class RecipeUpdateResponse implements Responsable
{
	protected $recipe;

	/**
	 * @param Collection $recipe
	 */
	public function __construct(Recipe $recipe)
	{
		$this->recipe = $recipe;
	}

	/**
	 * @param $request
	 */
	public function toResponse($request)
	{
		if ($this->recipe->ready() && user()->isAdmin()) {
			return redirect('/recipes')->withSuccess(trans('recipes.recipe_published'));
		}

		if ($this->recipe->ready()) {
			return redirect('/users/' . user()->id)->withSuccess(trans('recipes.added_to_approving'));

			// @TODO: turned off
			//event(new RecipeIsReady($this->recipe));
		}

		return back()->withSuccess(trans('recipes.saved'));
	}
}
