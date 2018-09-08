<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
