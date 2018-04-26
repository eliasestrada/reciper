<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
	protected $fillable = [ 'name', 'title', 'text' ];
	public $timestamps  = false;
}
