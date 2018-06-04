<?php

namespace App\Models\Trans;

use Schema;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
	protected $fillable = [ 'name', 'title', 'text' ];
	public $timestamps  = false;
}
