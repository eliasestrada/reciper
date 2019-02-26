<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
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
     * Relationship with Visitor model
     */
    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    /**
     * Relationship with Recipe model
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
