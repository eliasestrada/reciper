<?php

namespace App\Models\Trans;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = [ 'categories' ];
	public $timestamps  = false;

	public function recipes() {
		return $this->hasMany(Recipe::class);
	}
}
