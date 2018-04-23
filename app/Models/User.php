<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // The attributes that are mass assignable.
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function recipes() {
        return $this->hasMany(Recipe::class);
	}
	
	public function notifications() {
		return $this->hasMany(Notification::class);
	}

    // The attributes that should be hidden for arrays.
    protected $hidden = [
        'password', 'remember_token',
	];

	public function isAdmin() {
        return $this->admin === 1 ? true : false;
	}

	public function isAuthor() {
        return $this->author === 1 ? true : false;
	}
	
	public function hasRecipe($recipe_user_id) {
        return $this->id === $recipe_user_id ? true : false;
	}
}