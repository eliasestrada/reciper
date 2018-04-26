<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
	protected $fillable = [
		'title',   'intro',    'ingredients', 'advice',
		'text',    'time',     'category',    'author',
		'ready',   'approved', 'image',       'user_id'
	];

    public function user() {
        return $this->belongsTo(User::class);
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