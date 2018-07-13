<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Traits\RecipeModelShortcuts;
use App\Helpers\Traits\RecipeModelRelationship;

class Recipe extends Model
{
	use RecipeModelShortcuts, RecipeModelRelationship;

	protected $guarded = ['id'];

	/**
	 * @return string
	 */
	public function ingredientsWithListItems() : string
	{
		return convertToListItems($this->getIngredients());
	}

	/**
	 * @return string
	 */
	public function textWithListItems() : string
	{
		return convertToListItems($this->getText());
	}
}