<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = ['id'];
    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param string $title
     * @param string $message
     * @param string|null $data
     * @param integer $user_id
     * @return void
     */
    public static function sendToUser(string $title, string $message, ?string $data, int $user_id): void
    {
        self::create([
            'title' => "notifications.$title",
            'message' => $message,
            'user_id' => $user_id,
            'data' => $data,
        ]);
    }

    /**
     * @param string $title
     * @param string $message
     * @param string|null $data
     * @return void
     */
    public static function sendToAdmin(string $title, string $message, ?string $data): void
    {
        self::create([
            'title' => "notifications.$title",
            'message' => $message,
            'data' => $data,
            'for_admins' => 1,
        ]);
    }
}
