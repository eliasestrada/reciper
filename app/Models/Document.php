<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * Guarder columns
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Returns title column from db
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->toArray()['title_' . LANG()];
    }

    /**
     * Returns text column from db
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->toArray()['text_' . LANG()];
    }

    /**
     * Check if recipe has ready column set to 1
     *
     * @return boolean
     */
    public function isReady(): bool
    {
        return $this->toArray()['ready_' . LANG()];
    }

    /**
     * Scope that selects common columns from db
     *
     * @param $query
     * @return void
     */
    public function scopeSelectBasic($query)
    {
        return $query->select('id', 'title_' . LANG() . ' as title', 'text_' . LANG() . ' as text');
    }

    /**
     * Scope that selects only records from db that are ready
     *
     * @param [type] $query
     * @param integer $value
     * @return void
     */
    public function scopeIsReady($query, int $value)
    {
        return $query->where('ready_' . LANG(), $value);
    }
}
