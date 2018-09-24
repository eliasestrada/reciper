<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];
    protected $hidden = ['password', 'remember_token'];
    protected $dates = ['created_at', 'updated_at', 'online_at'];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
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
     * @param int $user_id
     * @param float $exp
     * @return void
     */
    public static function addExp(float $exp, int $user_id)
    {
        $user = User::find($user_id);
        $user->exp = $user->exp + $exp;
        $user->save();
    }

    /**
     * @param int $user_id
     * @param float $exp
     * @return void
     */
    public static function removeExp(float $exp, int $user_id)
    {
        $user = User::find($user_id);
        $user->exp = $user->exp - $exp;
        $user->save();
    }
}
