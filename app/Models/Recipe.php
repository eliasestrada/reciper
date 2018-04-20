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

	public function ingredientsWithListItems() {
		return convertToListItems($this->ingredients);
	}

	public function textWithListItems() {
		return convertToListItems($this->text);
	}
	
	public function ready() {
		return $this->ready === 1 ? true : false;
	}

	public function approved() {
		return $this->approved === 1 ? true : false;
	}
}