<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
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
    protected $table = 'ban';

    /**
     * Use or not laravel timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relationship with User model
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Adds user to ban list
     *
     * @param integer $user_id
     * @param integer $days
     * @param string $message
     * @param bool $create
     */
    public static function put(int $user_id, int $days, string $message, bool $create = true)
    {
        return $create
        ? self::create(compact('user_id', 'days', 'message'))
        : self::make(compact('user_id', 'days', 'message'));
    }
}
