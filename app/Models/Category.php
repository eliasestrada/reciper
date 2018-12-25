<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Guarder columns
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Use or not laravel timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relationship with Recipe model
     */
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }

    /**
     * Returns category name from database
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->toArray()['name_' . LANG()];
    }
}
