<?php

namespace App\Models;

use Schema;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
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
	
	public function ready() {
		return $this->toArray()['ready_' . locale()] === 1 ? true : false;
	}

	public function approved() {
		return $this->toArray()['approved_' . locale()] === 1 ? true : false;
	}

	// Functions shortcuts
	public function getTitle()
	{
		return $this->toArray()['title_' . locale()];
	}

	public function getIngredients()
	{
		return $this->toArray()['ingredients_' . locale()];
	}

	public function getIntro()
	{
		return $this->toArray()['intro_' . locale()];
	}

	public function getText()
	{
		return $this->toArray()['text_' . locale()];
	}
}