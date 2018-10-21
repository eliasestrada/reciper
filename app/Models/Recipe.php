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
        return to_array_of_list_items($this->getIngredients());
    }

    /**
     * @return array
     */
    public function textWithListItems(): array
    {
        return to_array_of_list_items($this->getText());
    }

    /**
     * @param $query
     * @param integer $value
     */
    public function scopeReady($query, int $value)
    {
        return $query->where('ready_' . LANG(), $value);
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
            'title_' . LANG(),
            'intro_' . LANG(),
            'ready_' . LANG(),
            'approved_' . LANG(),
            'image',
            'time',
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
        return $query->where('approved_' . LANG(), $value);
    }

    /**
     * @param $query
     * @param integer $value
     */
    public function scopeDone($query, int $value)
    {
        return $query
            ->where('ready_' . LANG(), $value)
            ->where('approved_' . LANG(), $value);
    }

    /**
     * @param int $limit
     * @param int $edge
     * @param int|null $visitor_id
     * @return object
     */
    public static function getRandomUnseen(int $limit = 12, int $edge = 8, ?int $visitor_id = null): object
    {
        $seen = View::whereVisitorId($visitor_id ?? visitor_id())->pluck('recipe_id');

        $random = self::inRandomOrder()
            ->where($seen->map(function ($id) {
                return ['id', '!=', $id];
            })->toArray())
            ->selectBasic()
            ->done(1)
            ->limit($limit)
            ->get();

        // If not enough recipes to display, show just random recipes
        if ($random->count() < $edge) {
            return self::inRandomOrder()->selectBasic()->done(1)->limit($limit)->get();
        }
        return $random;
    }
}
