<?php

namespace App\Helpers;

use Image;
use App\User;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Helpers\Contracts\SaveRecipeDataContract;

class SaveRecipeData implements SaveRecipeDataContract {

	public $imageName;

	/**
	 * Returns name of uploaded file, if file doen not exist,
	 * it will return string with the default file name
	 * 
	 * @param Request $request
	 * @param User $user
	 * @param Recipe $recipe
	 */
	public static function save(Request $request, User $user, Recipe $recipe) {
		$thisClass = new self;
		$thisClass->uploadImageToStorage($request);
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
		$recipe->image = $thisClass->whatNameOfUploadedImage();
	}

	/**
	 * Returns name of uploaded file, if file doen not exist,
	 * it will return string with the default file name
	 * 
	 * @return string
	 * @param Request $request
	 */
	public function uploadImageToStorage(Request $request) {
		if ($request->hasFile('изображение')) {
        	$image = $request->file('изображение');
			$filename = time() . rand() . '.' . $image->getClientOriginalExtension();
			
            Image::make($image)->resize(600, 400)->save(
				storage_path('app/public/images/' . $filename
			));

        	$this->imageName = $filename;
        } else {
        	$this->imageName = 'default.jpg';
        }
	}

	/**
	 * @return string
	 */
	public function whatNameOfUploadedImage() {
		return $this->imageName;
	}
}