<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $guarded = ['id'];

    public static function incrementRequestsOrCreate()
    {
        

        return (self::whereIp(request()->ip())->count() > 0)
        ? self::whereIp(request()->ip())->increment('requests')
        : self::create(['ip' => request()->ip()]);
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
