<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = ['id'];

    public function getTitle()
    {
        return $this->toArray()['title_' . locale()];
    }
}
