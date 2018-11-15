<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpCategory extends Model
{
    /**
     * Guarder columns
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * String that represents the name of the table
     *
     * @var string
     */
    protected $table = 'help_categories';

    /**
     * Use or not laravel timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Returns the title of the category
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->toArray()['title_' . LANG()];
    }

    /**
     * Scope that select most common columns from db
     *
     * @param $query
     */
    public function scopeSelectBasic($query)
    {
        return $query->select('id', 'title_' . LANG() . ' as title', 'icon');
    }
}
