<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public function likes()
    {
        return $this->hasOne(Recipe::class);
    }
}
