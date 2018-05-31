<?php

namespace App\Helpers\Traits;

use Image;
use Illuminate\Support\Facades\Storage;

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
		return 'default.jpg';
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
			'image' => $image_name,
			'category_id' => $request->category_id,
			'title' => $request->title,
			'intro' => $request->intro,
			'ingredients' => $request->ingredients,
			'advice' => $request->advice,
			'text' => $request->text,
			'time' => $request->time,
			'ready' => isset($request->ready) ? 1 : 0,
			'approved' => user()->isAdmin() ? 1 : 0
		];

		return $recipe
			? $recipe->update($recipe_columns)
			: user()->recipes()->create($recipe_columns);
	}
}