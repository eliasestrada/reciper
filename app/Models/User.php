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
        ['lvl' => 0, 'min' => 0, 'max' => 2],
        ['lvl' => 1, 'min' => 2, 'max' => 4],
        ['lvl' => 2, 'min' => 4, 'max' => 8],
        ['lvl' => 3, 'min' => 8, 'max' => 16],
        ['lvl' => 4, 'min' => 16, 'max' => 32],
        ['lvl' => 5, 'min' => 32, 'max' => 64],
        ['lvl' => 6, 'min' => 64, 'max' => 130],
        ['lvl' => 7, 'min' => 130, 'max' => 230],
        ['lvl' => 8, 'min' => 230, 'max' => 513],
        ['lvl' => 9, 'min' => 513, 'max' => 999],
        ['lvl' => 10, 'min' => 999, 'max' => 999],
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
        if ($column == 'exp') {
            $exp = User::whereId($user_id)->value('exp');

            if ($exp <= (config('custom.max_exp') - $points)) {
                User::whereId($user_id)->increment('exp', $points);
            } else {
                User::whereId($user_id)->increment('exp', config('custom.max_exp') - $exp);
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
            if ($this->exp >= $level['min'] && $this->exp < $level['max']) {
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
        return $this->levels[$this->getLvl()]['min'];
    }

    /**
     * @return int
     */
    public function getLvlMax(): int
    {
        return $this->levels[$this->getLvl()]['max'];
    }
}
