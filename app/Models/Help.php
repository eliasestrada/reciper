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
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * String that represents the name of the table
     *
     * @var string $table
     */
    protected $table = 'help';

    /**
     * Guarder columns
     *
     * @var array $guarded
     */
    protected $guarded = ['id'];

    /**
     * @var array $casts
     */
    protected $casts = ['deleted_at' => 'string'];

    /**
     * Use or not laravel timestamps
     *
     * @var bool $timestamps
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
        return $this->toArray()[_('title')];
    }

    /**
     * Method returning text field from database
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->toArray()[_('text')];
    }
}
