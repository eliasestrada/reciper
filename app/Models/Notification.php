<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	// The attributes that are mass assignable.
	protected $guarded = [ 'id' ];

    public function user() {
		return $this->belongsTo(User::class);
	}

	public static function recipeHasBeenApproved($title, $user_id) {
		self::create([
			'user_id'    => $user_id,
			'title'      => 'Рецепт опубликован',
			'message'    => 'Рецепт под названием "' . $title . '" был опубликован.'
		]);
	}

	public static function recipeHasNotBeenCreated($title, $user_id) {
		self::create([
			'user_id'    => $user_id,
			'title'      => 'Рецепт не опубликован',
			'message'    => 'Рецепт под названием "' . $title . '" не был опубликован 
							так как администрация венула его вам на переработку.'
		]);
	}
}
