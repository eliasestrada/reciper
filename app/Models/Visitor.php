<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $guarded = ['id'];

    public static function incrementRequestsOrCreate()
    {
        if (self::whereIp(request()->ip())->doesntExist()) {
            self::create(['ip' => request()->ip()]);
        }
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }
}
