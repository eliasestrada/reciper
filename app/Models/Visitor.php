<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $guarded = ['id'];

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public static function updateOrCreateNewVisitor()
    {
        return self::updateOrCreate(
            ['ip' => request()->ip()],
            ['updated_at' => now()]
        );
    }

    /**
     * @return int
     */
    public function daysWithUs(): int
    {
        return \Carbon\Carbon::parse($this->created_at)->diffInDays(now());
    }
}
