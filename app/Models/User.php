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

    public function isAdmin()
    {
        return $this->admin === 1 ? true : false;
    }

    public function isMaster()
    {
        return $this->master === 1 ? true : false;
    }

    public function hasRecipe($recipe_id)
    {
        return Recipe::where(['id' => $recipe_id, 'user_id' => $this->id])->exists();
    }
}
