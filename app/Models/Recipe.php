<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
	// The attributes that are mass assignable.
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo('App\User');
	}

	// Accessor
	public function getIngredientsAttribute($value) {
		return convertToListItems($value);
	}

	// Accessor
	public function getTextAttribute($value) {
		return convertToListItems($value);
	}
	
	public function ready() {
		return $this->ready === 1 ? true : false;
	}

	public function approved() {
		return $this->approved === 1 ? true : false;
	}
}