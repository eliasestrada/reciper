<?php

namespace App\Helpers;

use Image;
use App\User;
use App\Recipe;
use Illuminate\Http\Request;
use App\Helpers\Contracts\SaveRecipeDataContract;

class SaveRecipeData implements SaveRecipeDataContract {
	public static function save(Request $request, User $user, Recipe $recipe){
		$user = auth()->user();

        // Create Recipe in DB
        $recipe->title = $request->input('название');
        $recipe->intro = $request->input('описание');
        $recipe->ingredients = $request->input('ингридиенты');
        $recipe->advice = $request->input('совет');
        $recipe->text = $request->input('приготовление');
        $recipe->time = $request->input('время');
        $recipe->category = $request->input('категория');
        $recipe->user_id = $user->id;
        $recipe->author = $user->name;

        // Handle image uploading
        if ($request->hasFile('изображение')) {
        	$image = $request->file('изображение');
			$filename = time() . rand() . '.' . $image->getClientOriginalExtension();
			
            Image::make($image)->resize(600, 400)->save(
				storage_path('app/public/images/' . $filename
			));

        	$recipe->image = $filename;
        } else {
        	$recipe->image = 'default.jpg';
        }
	}
}