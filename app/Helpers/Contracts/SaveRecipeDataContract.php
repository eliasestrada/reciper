<?php

namespace App\Helpers\Contracts;

use App\User;
use App\Recipe;
use Illuminate\Http\Request;

Interface SaveRecipeDataContract {
	public static function save(Request $request, User $user, Recipe $recipe);
	public function uploadImageToStorage(Request $request);
	public function whatNameOfUploadedImage();
}