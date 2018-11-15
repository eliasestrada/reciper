<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Help extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * String that represents the name of the table
     *
     * @var string
     */
    protected $table = 'help';

    /**
     * Guarder columns
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Use or not laravel timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relationships with HelpCategory model
     */
    public function category()
    {
        return $this->belongsTo(HelpCategory::class, 'help_category_id');
    }

    /**
     * Method returning title field from database
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->toArray()['title_' . LANG()];
    }

    /**
     * Method returning text field from database
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->toArray()['text_' . LANG()];
    }

    /**
     * Scope for selecting common fields from database
     *
     * @param $query
     */
    public function scopeSelectBasic($query)
    {
        return $query->select('id', 'title_' . LANG() . ' as title', 'help_category_id');
    }
}
