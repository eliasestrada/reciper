<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
	protected $fillable = ['ip', 'name'];

	public static function incrementRequestsOrCreateIfNewVisitor() {
		return ( self::whereIp(request()->ip())->count() > 0 )
			? self::whereIp(request()->ip())->increment('requests')
			: self::create(['ip' => request()->ip()]);
	}
}
