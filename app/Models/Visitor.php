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
        if ($this->ban()->exists()) {
            // If ban time is passed delete visitor from banlist
            if ($this->ban->created_at <= now()->subDays($this->ban->days)) {
                $this->ban()->delete();
                return false;
            }
            return true;
        }
        return false;
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

    /**
     * @return string
     */
    public function getStatusColor(): string
    {
        if ($this->isBanned()) {
            return 'red';
        } elseif ($this->user) {
            return 'green';
        }
        return 'main';
    }
}
