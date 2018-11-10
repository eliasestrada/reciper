<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
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

    public function likes()
    {
        return $this->hasMany(Like::class);
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
     * @return int
     */public function daysWithUs(): int
    {return \Carbon\Carbon::parse($this->created_at)->diffInDays(now());
    }

    public function ban()
    {
        return $this->hasOne(Ban::class);
    }

    /**
     * @return boolean
     */
    public function isBanned(): bool
    {
        if ($this->ban()->exists()) {
            // If ban time is passed delete user from banlist
            if ($this->ban->created_at <= now()->subDays($this->ban->days)) {
                $this->ban()->delete();
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getStatusColor(): string
    {
        if ($this->isActive() && !$this->isBanned()) {
            return 'green';
        } else if ($this->isBanned()) {
            return 'main';
        }
        return 'red';
    }

    /**
     * If no name use username
     * @return void
     */
    public function getName()
    {
        return is_null($this->name) || $this->name == '' ? $this->username : $this->name;
    }

    /**
     * @return boolean
     */
    public function isActive(): bool
    {
        return $this->active === 1;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this));
    }

    /**
     * Returns true if user verified the email
     *
     * @return boolean
     */
    public function verified(): bool
    {
        return is_null($this->token);
    }
}
