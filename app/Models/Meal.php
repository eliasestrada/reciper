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
        return $this->toArray()[_('name')];
    }
}
