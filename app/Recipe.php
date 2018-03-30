<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
	}
	
	public function presentIngredients() {
		return convertToListItems($this->ingredients);
	}

	public function presentText() {
		return convertToListItems($this->text);
	}
}