<?php

namespace App\Models;

use App\Helpers\Traits\RecipeModelRelationship;
use App\Helpers\Traits\RecipeModelShortcuts;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use RecipeModelShortcuts, RecipeModelRelationship;

    protected $guarded = ['id'];

    /**
     * @return array
     */
    public function ingredientsWithListItems(): array
    {
        return convertToArrayOfListItems($this->getIngredients());
    }

    /**
     * @return array
     */
    public function textWithListItems(): array
    {
        return convertToArrayOfListItems($this->getText());
    }

    /**
     * @param $query
     * @param integer $value
     */
    public function scopeReady($query, int $value)
    {
        return $query->where('ready_' . lang(), $value);
    }

    /**
     * @param $query
     * @param integer $value
     */
    public function scopeApproved($query, int $value)
    {
        return $query->where('approved_' . lang(), $value);
    }
}
