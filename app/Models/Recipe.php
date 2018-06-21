<?php

namespace App\Models;

use Schema;
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

	/**
	 * @return bool
	 */
	public function ready() : bool
	{
		return $this->getReady() === 1 ? true : false;
	}

	/**
	 * @return bool
	 */
	public function approved() : bool
	{
		return $this->getApproved() === 1 ? true : false;
	}


	/**
	 * @return bool
	 */
	public function done() : bool
	{
		return ($this->getReady() === 1 && $this->getApproved() === 1)
			? true
			: false;
	}

	/**
	 * @return string
	 */
	public function getStatus() : string
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