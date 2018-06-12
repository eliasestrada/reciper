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

	public function categories() {
        return $this->belongsToMany(Category::class);
	}

	public function ingredientsWithListItems() {
		return convertToListItems($this->getIngredients());
	}

	public function textWithListItems() {
		return convertToListItems($this->getText());
	}
}