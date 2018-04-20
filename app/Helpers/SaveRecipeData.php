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
	 * @param Recipe $recipe
	 */
	public static function save(Request $request, Recipe $recipe) {
		$thisClass = new self;
		$thisClass->uploadImageToStorage($request);

		// Create Recipe in DB
        $recipe->title        = $request->input('title');
        $recipe->intro        = $request->input('intro');
        $recipe->ingredients  = $request->input('ingredients');
        $recipe->advice       = $request->input('advice');
        $recipe->text         = $request->input('text');
        $recipe->time         = $request->input('time');
        $recipe->category     = $request->input('category');
        $recipe->user_id      = user()->id;
        $recipe->author       = user()->name;
		$recipe->image        = $thisClass->whatNameOfUploadedImage();
	}

	/**
	 * Returns name of uploaded file, if file doen not exist,
	 * it will return string with the default file name
	 * 
	 * @return string
	 * @param Request $request
	 */
	public function uploadImageToStorage(Request $request) {
		if ($request->hasFile('image')) {
        	$image = $request->file('image');
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