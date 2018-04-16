<?php

namespace App\Models;

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

	public function ready() {
		return $this->ready === 1 ? true : false;
	}

	public function approved() {
		return $this->approved === 1 ? true : false;
	}
}