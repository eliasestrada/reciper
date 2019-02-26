<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fav extends Model
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
     * Relatinship with User model
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relatinship with Recipe model
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
