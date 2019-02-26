<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Guarder columns
     *
     * @var array $guarded
     */
    protected $guarded = ['id'];

    /**
     * Use or not laravel timestamps
     *
     * @var bool $timestamps
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
        return $this->toArray()[_('name')];
    }
}
