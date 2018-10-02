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
        return convert_to_array_of_list_items($this->getIngredients());
    }

    /**
     * @return array
     */
    public function textWithListItems(): array
    {
        return convert_to_array_of_list_items($this->getText());
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
     * @param array $aditional
     * @param array $mute
     */
    public function scopeSelectBasic($query, array $aditional = [], array $mute = [])
    {
        $sql = array_collapse([[
            'id',
            'title_' . lang(),
            'intro_' . lang(),
            'ready_' . lang(),
            'approved_' . lang(),
            'image',
            'updated_at',
        ], $aditional]);

        $sql = array_where($sql, function ($value, $key) use ($mute) {
            return !array_has($mute, $key);
        });

        return $query->select($sql);
    }

    /**
     * @param $query
     * @param integer $value
     */
    public function scopeApproved($query, int $value)
    {
        return $query->where('approved_' . lang(), $value);
    }

    /**
     * @param $query
     * @param integer $value
     */
    public function scopeDone($query, int $value)
    {
        return $query
            ->where('ready_' . lang(), $value)
            ->where('approved_' . lang(), $value);
    }
}
