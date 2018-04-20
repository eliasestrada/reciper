<?php

namespace App\Helpers\Contracts;

use App\User;
use App\Models\Recipe;
use Illuminate\Http\Request;

Interface SaveRecipeDataContract {
	public static function save(Request $request, Recipe $recipe);
	public function uploadImageToStorage(Request $request);
	public function whatNameOfUploadedImage();
}