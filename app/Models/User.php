<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $dates = [
        'created_at',
        'updated_at',
        'online_at',
    ];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return $this->admin === 1 ? true : false;
    }

    /**
     * @return boolean
     */
    public function isMaster(): bool
    {
        return $this->master === 1 ? true : false;
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
     * @param int $user_id
     * @param float $points
     * @return void
     */
    public function addPoints(float $points, int $user_id)
    {
        $user = User::find($user_id);
        $user->points = $user->points + $points;
        $user->save();
    }
}
