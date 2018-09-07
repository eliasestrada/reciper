<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;

class NotificationController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notifications = Notification::whereUserId(user()->id);

        if (user()->isAdmin()) {
            $notifications->orWhere('for_admins', 1);
        }

        User::whereId(user()->id)->update([
            'notif_check' => now(),
        ]);

        return view('notifications.index', [
            'notifications' => $notifications->latest()->paginate(10)->onEachSide(1),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @param Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        if ($notification->for_admins !== 1) {
            $notification->delete();
            return redirect('notifications')->withSuccess(
                trans('notifications.deleted')
            );
        }
        return redirect('notifications');
    }
}
