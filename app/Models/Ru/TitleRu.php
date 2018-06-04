<?php

namespace App\Models\Ru;

use Illuminate\Database\Eloquent\Model;

class TitleRu extends Model
{
	protected $table = 'titles_ru';
	protected $fillable = [ 'name', 'title', 'text' ];
	public $timestamps  = false;
}
