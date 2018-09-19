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

    public function ban()
    {
        return $this->hasOne(Ban::class);
    }

    public function isBanned(): bool
    {
        return $this->ban()->exists();
    }

    public static function incrementRequestsOrCreate()
    {
        self::updateOrCreate(
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
