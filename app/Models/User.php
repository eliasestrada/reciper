<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Guarder columns
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Hide fields when displaying data
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Relationship with Recipe model
     */
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    /**
     * Relationship with Role model
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Relationship with Fav model
     */
    public function favs()
    {
        return $this->hasMany(Fav::class);
    }

    /**
     * Relationship with Like model
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Relationship with Ban model
     */
    public function ban()
    {
        return $this->hasOne(Ban::class);
    }

    /**
     * Find out if user has a specific role
     *
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

    /**
     * Attach a new role to a user
     *
     * @return void
     */
    public function addRole(string $check): void
    {
        $roles = Role::get();

        foreach ($roles as $role) {
            if ($check === $role->name) {
                $this->roles()->attach($role);
            }
        }
    }

    /**
     * Check if user owns particular recipe or not
     *
     * @param integer $recipe_id
     * @return boolean
     */
    public function hasRecipe(int $recipe_id): bool
    {
        return Recipe::whereId($recipe_id)->whereUserId($this->id)->exists();
    }

    /**
     * Check if user has particular recipe added to his favorite list
     *
     * @param integer $recipe_id
     * @return boolean
     */
    public function hasFav(int $recipe_id): bool
    {
        return Fav::where([['user_id', $this->id], ['recipe_id', $recipe_id]])->exists();
    }

    /**
     * Shows how many days this user is with us
     *
     * @return int
     */
    public function daysWithUs(): int
    {
        return \Carbon\Carbon::parse($this->created_at)->diffInDays(now());
    }

    /**
     * Check if this user is banned or not
     *
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
     * Returns green if user is active and not banned
     * Reurns main color if user is banned
     * Returns red if user is not active
     *
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
     * If user doesn't have name then use username
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->{!$this->name || $this->name == '' ? 'username' : 'name'};
    }

    /**
     * Check if user is active or not
     *
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

    /**
     * @return \App\Models\User
     */
    public static function firstUser(): self
    {
        return self::whereId(1)->first();
    }
}
