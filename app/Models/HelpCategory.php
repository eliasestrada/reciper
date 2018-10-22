<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpCategory extends Model
{
    protected $table = 'help_categories';
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->toArray()['title_' . LANG()];
    }

    /**
     * @param $query
     */
    public function scopeSelectBasic($query)
    {
        return $query->select('id', 'title_' . LANG() . ' as title', 'icon');
    }
}
