<?php

namespace Tests\Feature\Views\Notifications;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NotificationsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $user = make(User::class);

        $this->actingAs($user)
            ->get('/notifications')
            ->assertViewIs('notifications.index')
            ->assertViewHas('notifications',
                Notification::whereUserId(user()->id)->latest()->paginate(18)->onEachSide(1)
            );
    }

    /** @test */
    public function user_can_see_the_page(): void
    {
        $user = make(User::class);

        $this->actingAs($user)
            ->get('/notifications')
            ->assertOk();
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/notifications')
            ->assertRedirect('/login');
    }

    /** @test */
    public function user_can_delete_his_notification_message(): void
    {
        $user = make(User::class);
        $text_message = 'This is a test notification to user';

        $notif = Notification::create([
            'user_id' => $user->id,
            'title' => 'Hello world',
            'message' => $text_message,
        ]);

        $this->actingAs($user)
            ->get('/notifications')
            ->assertSeeText($text_message);

        // Let's delete the notif
        $this->actingAs($user)
            ->delete(action('NotificationController@destroy', ['notification' => $notif->id]));

        // Notif should not be in DB
        $this->assertDatabaseMissing('notifications', ['message' => $text_message]);
    }
}
