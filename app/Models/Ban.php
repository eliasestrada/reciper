<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    protected $guarded = ['id'];
    protected $table = 'ban';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
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
