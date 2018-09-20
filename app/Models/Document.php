<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = ['id'];

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->toArray()['title_' . lang()];
    }

    /**
     * @return boolean
     */
    public function isReady(): bool
    {
        return $this->toArray()['ready_' . lang()];
    }

    /**
     * @param [type] $query
     * @param integer $value
     * @return void
     */
    public function scopeIsReady($query, int $value)
    {
        return $query->where('ready_' . lang(), $value);
    }
}
