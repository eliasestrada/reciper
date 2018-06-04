<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
	protected $table = 'titles_ru';
	protected $fillable = [ 'name', 'title', 'text' ];
	public $timestamps  = false;
}
