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

	public function category() {
        return $this->belongsTo(Category::class);
	}

	public function ingredientsWithListItems() {
		if (locale() === 'ru') {
			return convertToListItems($this->ingredients_ru);
		} elseif (locale() === 'en') {
			return convertToListItems($this->ingredients_en);
		}
	}

	public function textWithListItems() {
		if (locale() === 'ru') {
			return convertToListItems($this->text_ru);
		} elseif (locale() === 'en') {
			return convertToListItems($this->text_en);
		}
	}
	
	public function ready() {
		if (locale() === 'ru') {
			return $this->ready_ru === 1 ? true : false;
		} elseif (locale() === 'en') {
			return $this->ready_en === 1 ? true : false;
		}
	}

	public function approved() {
		if (locale() === 'ru') {
			return $this->approved_ru === 1 ? true : false;
		} elseif (locale() === 'en') {
			return $this->approved_en === 1 ? true : false;
		}
	}
}