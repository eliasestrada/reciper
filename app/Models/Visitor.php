<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $guarded = ['id'];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public static function incrementRequestsOrCreate()
    {
        self::updateOrCreate(
            ['ip' => request()->ip()],
            ['updated_at' => now()]
        );
    }

}
