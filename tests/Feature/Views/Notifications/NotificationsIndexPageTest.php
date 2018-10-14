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
                Notification::whereUserId($user->id)->latest()->paginate(18)->onEachSide(1)
            );
    }

    /** @test */
    public function user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))->get('/notifications')->assertOk();
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/notifications')->assertRedirect('/login');
    }

    /** @test */
    public function user_can_delete_his_notification_message(): void
    {
        $user = create_user();
        $notif = $this->new_notif($user->id);

        // Let's delete the notif
        $this->actingAs($user)->delete(action('NotificationController@destroy', [
            'notification' => $notif->id,
        ]));

        $this->assertDatabaseMissing('notifications', ['message' => $notif->message]);
    }

    /** @test */
    public function admin_dont_see_delete_button_for_admin(): void
    {
        $admin = create_user('admin');
        $notif = $this->new_notif($admin->id, true);

        $this->actingAs($admin)
            ->get('/notifications')
            ->assertDontSee(trans('forms.deleting') . '</button>');
    }

    /** @test */
    public function admin_cant_delete_notification_for_admin(): void
    {
        $admin = create_user('admin');
        $notif = $this->new_notif($admin->id, true);

        $this->actingAs($admin)->delete(action('NotificationController@destroy', [
            'notification' => $notif->id,
        ]));

        $this->assertDatabaseHas('notifications', ['message' => $notif->message]);
    }

    /** @test */
    public function user_dont_see_delete_button_for_admin(): void
    {
        $user = create_user();
        $notif = $this->new_notif($user->id, true);

        $this->actingAs($user)
            ->get('/notifications')
            ->assertDontSee(trans('forms.deleting') . '</button>');
    }

    /** @test */
    public function user_cant_delete_notification_for_admin(): void
    {
        $user = create_user();
        $notif = $this->new_notif($user->id, true);

        $this->actingAs($user)
            ->followingRedirects()
            ->delete(action('NotificationController@destroy', ['notification' => $notif->id]))
            ->assertSeeText(trans('notifications.cant_delete'));
    }

    /** @test */
    public function master_sees_delete_button_for_admin(): void
    {
        $master = create_user('master');
        $notif = $this->new_notif($master->id, true);

        $this->actingAs($master)
            ->get('/notifications')
            ->assertSee(trans('forms.deleting') . '</button>');
    }

    /** @test */
    public function master_can_delete_notification_for_admin(): void
    {
        $master = create_user('master');
        $notif = $this->new_notif($master->id, true);

        $this->actingAs($master)->delete(action('NotificationController@destroy', [
            'notification' => $notif->id,
        ]));

        $this->assertDatabaseMissing('notifications', ['message' => $notif->message]);
    }

    /**
     * @param integer $user_id
     * @param $for_admins
     */
    public function new_notif(int $user_id, bool $for_admins = false)
    {
        return Notification::create([
            'user_id' => $user_id,
            'title' => str_random(3),
            'message' => str_random(10),
            'for_admins' => $for_admins ? 1 : 0,
        ]);
    }
}
