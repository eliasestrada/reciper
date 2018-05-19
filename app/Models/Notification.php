<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $guarded = ['id'];

    public function user() {
		return $this->belongsTo(User::class);
	}

	public static function recipeHasBeenApproved($title, $user_id) {
		self::create([
			'user_id' => $user_id,
			'title' => trans('notifications.recipe_published'),
			'message' => trans('notifications.recipe_with_title_published', ['title' => $title])
		]);
	}

	public static function recipeHasNotBeenCreated($title, $user_id) {
		self::create([
			'user_id' => $user_id,
			'title' => trans('notifications.recipe_not_published'),
			'message' => trans('notifications.recipe_with_title_not_published', ['title' => $title])
		]);
	}
}
