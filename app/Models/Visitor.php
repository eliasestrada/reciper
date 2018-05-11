<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
	protected $fillable = ['ip', 'name'];

    public static function getIpAddressFromVisitor() {
		return request()->ip();
	}

	public static function firstOrCreateNewVisitor() {
		return self::firstOrCreate([
			'ip' => self::getIpAddressFromVisitor()
		]);
	}

}
