<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
	public $timestamps = false;
	
	// The attributes that are mass assignable.
	protected $fillable = [
		'name', 'title', 'text'
	];
}
