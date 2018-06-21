<?php

namespace App\Helpers\Traits;

use App\Models\Like;
use App\Models\Meal;
use App\Models\Category;

trait RecipeModelRelationship
{
	public function user()
	{
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
}
