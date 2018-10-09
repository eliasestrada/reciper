<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    /**
     * @param integer $value
     * @return boolean
     */
    public function isReport(int $value)
    {
        return $this->is_report == $value;
    }
}
