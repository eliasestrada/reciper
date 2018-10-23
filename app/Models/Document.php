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
        return $this->toArray()['title_' . LANG()];
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->toArray()['text_' . LANG()];
    }

    /**
     * @param $query
     * @return void
     */
    public function scopeSelectBasic($query)
    {
        return $query->select('id', 'title_' . LANG() . ' as title', 'text_' . LANG() . ' as text');
    }

    /**
     * @return boolean
     */
    public function isReady(): bool
    {
        return $this->toArray()['ready_' . LANG()];
    }

    /**
     * @param [type] $query
     * @param integer $value
     * @return void
     */
    public function scopeIsReady($query, int $value)
    {
        return $query->where('ready_' . LANG(), $value);
    }
}
