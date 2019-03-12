<?php

namespace App\Helpers\Models;

use App\Models\Category;
use App\Models\Fav;
use App\Models\Like;
use App\Models\Meal;
use App\Models\User;
use App\Models\View;

trait RecipeHelpers
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

    /**
     * Get title column from db
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->toArray()[_('title')];
    }

    /**
     * Get ingredients column from db
     *
     * @return string
     */
    public function getIngredients(): ?string
    {
        return $this->toArray()[_('ingredients')];
    }

    /**
     * Get intro column from db
     *
     * @return string
     */
    public function getIntro(): ?string
    {
        return $this->toArray()[_('intro')];
    }

    /**
     * Get text column from db
     *
     * @return string
     */
    public function getText(): ?string
    {
        return $this->toArray()[_('text')];
    }

    /**
     * Check if this recipe has ready column set to 1
     *
     * @return bool
     */
    public function isReady(): bool
    {
        return $this->toArray()[_('ready')] === 1;
    }

    /**
     * Check if this recipe has approved column set to 1
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->toArray()[_('approved')] === 1;
    }

    /**
     * Check if this recipe has approved column set to 1
     * and ready column set to 1
     *
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->isReady() && $this->isApproved();
    }

    /**
     * Check if this recipe has published column set to 1
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->toArray()[_('published')] === 1;
    }

    /**
     * Returns status of the current recipe
     *
     * @return string
     */
    public function getStatusText(): string
    {
        switch (true) {
            case $this->isDone():
                return trans('users.checked');
                break;

            case !$this->isReady():
                return trans('users.not_ready');
                break;

            default:
                return trans('users.is_checking');
        }
    }

    /**
     * Returns font awesome icon of the current recipe,
     * dipending of the current recipe status
     *
     * @return string
     */
    public function getStatusIcon(): string
    {
        switch (true) {
            case $this->isDone():
                return 'fa-check';
                break;

            case !$this->isReady():
                return 'fa-pen';
                break;

            default:
                return 'fa-clock';
        }
    }

    /**
     * Returns color of the current recipe,
     * dipending of the current recipe status
     *
     * @return string
     */
    public function getStatusColor(): string
    {
        switch (true) {
            case $this->isDone():
                return '#65b56e';
                break;

            case !$this->isReady():
                return '#ce7777';
                break;

            default:
                return '#e2bd18';
        }
    }

    /**
     * This method will update recipe and set ready,
     * approved and approver_id field to 0
     * 
     * @return bool
     */
    public function moveToDrafts(): bool
    {
        return $this->update([
            _('ready') => 0,
            _('approved') => 0,
            _('approver_id', true) => 0,
        ]);
    }
}
