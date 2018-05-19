<?php

namespace App\Observers;

use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;

class RecipeObserver
{
	/** Deleting recipe image file if recipe is deleting */
	public function deleting(Recipe $recipe) {
		if ($recipe->image != 'default.jpg') {
			Storage::delete('public/images/'.$recipe->image);
		}
	}
}