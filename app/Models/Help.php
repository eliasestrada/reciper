<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    protected $table = 'help';
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
     * @return string
     */
    public function getText(): string
    {
        return $this->toArray()['text_' . LANG()];
    }

    /**
     * @param $query
     */
    public function scopeSelectBasic($query)
    {
        return $query->select('id', 'title_' . LANG() . ' as title', 'help_category_id');
    }
}
