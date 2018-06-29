<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password',];
	protected $hidden   = ['password', 'remember_token'];
	protected $dates   = [
		'created_at',
		'updated_at',
		'last_visit_at'
	];

    public function recipes() {
        return $this->hasMany(Recipe::class);
	}

	public function notifications() {
		return $this->hasMany(Notification::class);
	}

	public function isAdmin() {
        return $this->admin === 1 ? true : false;
	}

	public function isMaster() {
        return $this->master === 1 ? true : false;
	}
	
	public function hasRecipe($recipe_user_id) {
        return $this->id === $recipe_user_id ? true : false;
	}
}