<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];
    protected $hidden = ['password', 'remember_token'];

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
}
