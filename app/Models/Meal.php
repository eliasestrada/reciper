<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    /**
     * Guarder columns
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * String that represents the name of the table
     *
     * @var string
     */
    protected $table = 'meal';

    /**
     * Use or not laravel timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relatinship with Recipe model
     */
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    /**
     * Returns the name of current meal
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->toArray()['name_' . LANG()];
    }

    /**
     * Selects common fields from db and caching them
     */
    public static function getWithCache()
    {
        return cache()->rememberForever('meal', function () {
            return self::select('id', 'name_' . LANG() . ' as name')->get()->toArray();
        });
    }
}
