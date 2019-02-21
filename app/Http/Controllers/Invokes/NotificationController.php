<?php

namespace App\Http\Controllers\Invokes;

use Cookie;
use App\Models\User;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Mark notifications as read and return cookie for 10 seconds
     * that prevent user from hitting database every click
     *
     * @return \Illuminate\Facades\Cookie
     */
    public function __invoke()
    {
        if (!request()->cookie('r_fiton')) {
            user()->unreadNotifications->markAsRead();
            return Cookie::queue('r_fiton', 1, 0.1);
        }
    }
}
