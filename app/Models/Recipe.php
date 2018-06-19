<?php

namespace App\Models;

use Schema;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Traits\RecipeModelShortcuts;

class Recipe extends Model
{
	use RecipeModelShortcuts;

	protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
	}


	public function meal()
	{
		return $this->belongsTo(Meal::class);
	}

	public function likes()
	{
		return $this->hasMany(Like::class);
	}

	public function categories() {
        return $this->belongsToMany(Category::class);
	}

	public function ingredientsWithListItems() {
		return convertToListItems($this->getIngredients());
	}

	public function textWithListItems() {
		return convertToListItems($this->getText());
	}

	public function ready() {
		return $this->getReady() === 1 ? true : false;
	}

	public function approved() {
		return $this->getApproved() === 1 ? true : false;
	}

	public function done() {
		return ($this->getReady() === 1 && $this->getApproved() === 1)
			? true
			: false;
	}

	public function getStatus()
	{
		if ($this->approved() === true) {
			return trans('users.checked');
		} elseif ($this->ready() === false) {
			return trans('users.not_ready');
		} else {
			return trans('users.not_checked');
		}
	}
}