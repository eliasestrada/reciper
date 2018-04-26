<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = [ 'categories' ];
	public $timestamps  = false;

	public function recipe() {
		return $this->belongsTo(Recipe::class);
	}
}
