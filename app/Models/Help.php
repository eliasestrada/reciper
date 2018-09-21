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
        return $this->toArray()['title_' . lang()];
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->toArray()['text_' . lang()];
    }
}