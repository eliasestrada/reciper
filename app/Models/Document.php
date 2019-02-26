<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * Guarder columns
     *
     * @var array $guarded
     */
    protected $guarded = ['id'];

    /**
     * Returns title column from db
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->toArray()[_('title')];
    }

    /**
     * Returns text column from db
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->toArray()[_('text')];
    }

    /**
     * Check if recipe has ready column set to 1
     *
     * @return bool
     */
    public function isReady(): bool
    {
        return $this->toArray()[_('ready')];
    }

    /**
     * Scope that selects common columns from db
     *
     * @param $query
     * @return void
     */
    public function scopeSelectBasic($query)
    {
        return $query->select('id', _('title') . ' as title', _('text') . ' as text');
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
        return $query->where(_('ready'), $value);
    }
}
