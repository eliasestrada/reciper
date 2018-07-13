<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
	protected $guarded = ['id'];
	public $timestamps  = false;

	/**
	 * @return string
	 */
	public function getTitle() : ? string
	{
		return $this->toArray()['title_' . locale()];
	}

	/**
	 * @return string
	 */
	public function getText() : ? string
	{
		return $this->toArray()['text_' . locale()];
	}
}
