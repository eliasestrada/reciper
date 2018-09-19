<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    protected $guarded = ['id'];
    protected $table = 'ban';
    const UPDATED_AT = null;

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    /**
     * @param integer $visitor_id
     * @param integer $days
     * @param string $message
     */
    public static function banVisitor(int $visitor_id, int $days, string $message)
    {
        return self::create(compact('visitor_id', 'days', 'message'));
    }
}
