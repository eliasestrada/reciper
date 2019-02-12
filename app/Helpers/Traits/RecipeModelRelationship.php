<?php

namespace App\Helpers\Traits;

use App\Models\Category;
use App\Models\Fav;
use App\Models\Like;
use App\Models\Meal;
use App\Models\User;
use App\Models\View;

trait RecipeModelRelationship
{
    /**
     * Relation with User model
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation with Meal model
     */
    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    /**
     * Relation with Like model
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Relation with Fav model
     */
    public function favs()
    {
        return $this->hasMany(Fav::class);
    }

    /**
     * Relation with View model
     */
    public function views()
    {
        return $this->hasMany(View::class);
    }

    /**
     * Relation with Category model
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Relation with User model, but it will bind admin that
     * approved recipe and recipe itself
     */
    public function approver()
    {
        return $this->belongsTo(User::class, _('approver_id', true));
    }
}
