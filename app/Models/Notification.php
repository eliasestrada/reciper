<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param string $title
     * @param string $message
     * @param integer $user_id
     * @return void
     */
    public static function sendToUser(string $title, string $message, int $user_id): void
    {
        self::create([
            'title' => $title,
            'message' => $message,
            'user_id' => $user_id,
        ]);
    }

    /**
     * @param string $title
     * @param string $message
     * @return void
     */
    public static function sendToAdmin(string $title, string $message): void
    {
        self::create([
            'title' => $title,
            'message' => $message,
            'for_admins' => 1,
        ]);
    }
}
