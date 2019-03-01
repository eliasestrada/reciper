<?php

namespace App\Models;

use App\Helpers\Models\RecipeHelpers;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use RecipeHelpers;

    /**
     * Guarder columns
     *
     * @var array $guarded
     */
    protected $guarded = ['id'];

    /**
     * Returns ingredients field from db, converted to array with
     * list items
     *
     * @return array
     */
    public function ingredientsWithListItems(): array
    {
        return to_array_of_list_items($this->getIngredients());
    }

    /**
     * Returns text field from db, converted to array with
     * list items
     *
     * @return array
     */
    public function textWithListItems(): array
    {
        return to_array_of_list_items($this->getText());
    }

    /**
     * Scope that selects recipes that have ready field set to 1
     *
     * @param $query
     * @param integer $value
     */
    public function scopeReady($query, int $value)
    {
        return $query->where(_('ready'), $value);
    }

    /**
     * Scope that returns only recipes that have approved field set to 1
     *
     * @param $query
     * @param integer $value
     */
    public function scopeApproved($query, int $value)
    {
        return $query->where(_('approved'), $value);
    }

    /**
     * Scope that returns only recipes that have approved field set to 1
     * and ready field set to 1
     *
     * @param $query
     * @param integer $value
     */
    public function scopeDone($query, int $value)
    {
        return $query->where([
            _('ready') => $value,
            _('approved') => $value,
        ]);
    }
}
