<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];
    protected $hidden = ['password', 'remember_token'];
    public $levels = [
        ['lvl' => 1, 'min' => 1, 'max' => 39],
        ['lvl' => 2, 'min' => 40, 'max' => 79],
        ['lvl' => 3, 'min' => 80, 'max' => 159],
        ['lvl' => 4, 'min' => 160, 'max' => 319],
        ['lvl' => 5, 'min' => 320, 'max' => 639],
        ['lvl' => 6, 'min' => 640, 'max' => 1299],
        ['lvl' => 7, 'min' => 1300, 'max' => 2299],
        ['lvl' => 8, 'min' => 2300, 'max' => 5129],
        ['lvl' => 9, 'min' => 5130, 'max' => 8999],
        ['lvl' => 10, 'min' => 9000, 'max' => 9001],
    ];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function favs()
    {
        return $this->hasMany(Fav::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    /**
     * Find out if user has a specific role
     * @param string $check
     * @return boolean
     */
    public function hasRole(string $check): bool
    {
        foreach ($this->roles as $role) {
            if ($role->name == $check) {
                return true;
            }
        }
        return false;
    }

    public function addRole(string $check)
    {
        $roles = Role::get();

        foreach ($roles as $role) {
            if ($check === $role->name) {
                $this->roles()->attach($role);
            }
        }
    }

    /**
     * @param integer $recipe_id
     * @return boolean
     */
    public function hasRecipe(int $recipe_id): bool
    {
        return Recipe::whereId($recipe_id)->whereUserId($this->id)->exists();
    }

    /**
     * @param integer $recipe_id
     * @return boolean
     */
    public function hasFav(int $recipe_id): bool
    {
        return Fav::where([['user_id', $this->id], ['recipe_id', $recipe_id]])->exists();
    }

    /**
     * @param string $column
     * @param int $user_id
     * @param float $points
     * @return void
     */
    public static function addPoints(string $column, float $points, int $user_id)
    {
        if ($column == 'xp') {
            $xp = User::whereId($user_id)->value('xp');

            if ($xp <= (config('custom.max_xp') - $points)) {
                User::whereId($user_id)->increment('xp', $points);
            } else {
                User::whereId($user_id)->increment('xp', config('custom.max_xp') - $xp);
            }
        } else {
            User::whereId($user_id)->increment($column, $points);
        }
    }

    /**
     * @param string $column
     * @param int $user_id
     * @param float $points
     * @return void
     */
    public static function removePoints(string $column, float $points, int $user_id)
    {
        User::whereId($user_id)->decrement($column, $points);
    }

    /**
     * @return int
     */
    public function getLvl(): int
    {
        $result = 0;
        foreach ($this->levels as $level) {
            if ($this->xp >= $level['min'] && $this->xp <= $level['max']) {
                $result = $level['lvl'];
            }
        }
        return $result;
    }

    /**
     * @return int
     */
    public function getLvlMin(): int
    {
        return $this->levels[$this->getLvl() - 1]['min'];
    }

    /**
     * @return int
     */
    public function getLvlMax(): int
    {
        return $this->levels[$this->getLvl() - 1]['max'];
    }
}
