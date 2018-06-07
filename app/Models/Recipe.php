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
		return convertToListItems($this->toArray()['ingredients_'.locale()]);
	}

	public function textWithListItems() {
		return convertToListItems($this->toArray()['text_'.locale()]);
	}
	
	public function ready() {
		return $this->toArray()['ready_'.locale()] === 1 ? true : false;
	}

	public function approved() {
		return $this->toArray()['approved_'.locale()] === 1 ? true : false;
	}
}