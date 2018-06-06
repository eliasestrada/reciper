<?php

namespace App\Helpers\Traits;

use Image;
use Storage;

trait RecipesControllerHelpers
{
	public function saveImageIfExists($image)
	{
		if ($image) {
			$extention = $image->getClientOriginalExtension();
			$image_name = setNameForRecipeImage($extention);

			Image::make($image)->resize(600, 400)->save(
				storage_path('app/public/images/' . $image_name
			));
			return $image_name;
		}
		return null;
	}


	public function deleteOldImage($image)
	{
		if ($image != 'default.jpg') {
			Storage::delete('public/images/'.$image);
		}
	}


	public function createOrUpdateRecipe($request, $image_name, $recipe = null)
	{
		$recipe_columns = [
			'image' => $image_name ? $image_name : $recipe->image ?? 'default.jpg',
			'category_id' => $request->category_id,
			'time' => $request->time,

			'title_'.locale() => $request->title,
			'intro_'.locale() => $request->intro,
			'text_'.locale() => $request->text,
			'ingredients_'.locale() => $request->ingredients,
			'ready_'.locale() => isset($request->ready) ? 1 : 0,
			'approved_'.locale() => user()->isAdmin() ? 1 : 0
		];

		return $recipe
			? $recipe->update($recipe_columns)
			: user()->recipes()->create($recipe_columns);
	}
}