<?php

namespace App\Helpers\Traits;

use App\Models\Category;
use App\Models\Like;
use App\Models\Meal;
use App\Models\User;
use App\Models\View;

trait RecipeModelRelationship
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, lang() . '_approver_id');
    }
}
