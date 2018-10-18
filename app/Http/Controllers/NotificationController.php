<?php

namespace App\Http\Controllers;

use App\Models\User;

class NotificationController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        user()->unreadNotifications->markAsRead();
        $notifications = user()->notifications()->select('data', 'created_at')->get()->toArray();
        return view('notifications.index', compact('notifications'));
    }
}
