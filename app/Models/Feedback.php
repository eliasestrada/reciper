<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    /**
     * Guarder columns
     *
     * @var array $guarded
     */
    protected $guarded = ['id'];

    /**
     * Use or not laravel timestamps
     *
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * Relatinship with Recipe model
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    /**
     * Relatinship with Visitor model
     */
    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    /**
     * Check if this record is users' report or simple feedback
     *
     * @param integer $value
     * @return bool
     */
    public function isReport(int $value): bool
    {
        return $this->is_report == $value;
    }
}
