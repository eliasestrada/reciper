<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $table = 'meal';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function getName(): string
    {
        return $this->toArray()['name_' . lang()];
    }

    public static function getWithCache()
    {
        return cache()->rememberForever('meal', function () {
            return self::select('id', 'name_' . lang() . ' as name')->get()->toArray();
        });
    }
}
