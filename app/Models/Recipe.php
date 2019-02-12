<?php

namespace App\Models;

use App\Helpers\Traits\RecipeModelRelationship;
use App\Helpers\Traits\RecipeModelShortcuts;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use RecipeModelShortcuts, RecipeModelRelationship;

    /**
     * Guarder columns
     *
     * @var array
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
        return $query
            ->where(_('ready'), $value)
            ->where(_('approved'), $value);
    }

    /**
     * Returns only those recipes that user haven't seen, if there no recipes
     * the he haven't seen, shows just random recipes
     *
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
            ->done(1)
            ->limit($limit)
            ->get();

        // If not enough recipes to display, show just random recipes
        if ($random->count() < $edge) {
            return self::inRandomOrder()->done(1)->limit($limit)->get();
        }
        return $random;
    }
}
