<?php

namespace App\Models\Trans;

use Schema;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
	protected $table = 'titles_ru';
	protected $fillable = [ 'name', 'title', 'text' ];
	public $timestamps  = false;

	/**
	 * Name of the table depends on locale state
	 */
	public function __construct()
	{
		if (Schema::hasTable('title_' . locale())) {
			$this->table = 'titles_' . locale();
		}
	}
}
