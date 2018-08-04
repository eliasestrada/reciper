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
     * @return string
     */
    public function ingredientsWithListItems(): string
    {
        return convertToListItems($this->getIngredients());
    }

    /**
     * @return string
     */
    public function textWithListItems(): string
    {
        return convertToListItems($this->getText());
    }
}
