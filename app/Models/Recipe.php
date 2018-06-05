<?php

namespace App\Models;

use Schema;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
	protected $guarded = [ 'id' ];

    public function user() {
        return $this->belongsTo(User::class);
	}

	public function meal()
	{
		return $this->belongsTo(Meal::class);
	}

	public function category() {
        return $this->belongsTo(Category::class);
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