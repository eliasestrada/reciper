<?php

namespace Tests\Feature\Views\Notifications;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NotificationsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/notificatons/index
     * @test
     * @return void
     */
    public function view_notifications_index_has_data(): void
    {
        $user = make(User::class);

        $this->actingAs($user)
            ->get('/notifications')
            ->assertViewIs('notifications.index')
            ->assertViewHas('notifications',
                Notification::whereUserId(user()->id)->latest()->paginate(10)
            );
    }

    /**
     * resources/views/notificatons/index
     * @test
     * @return void
     */
    public function user_can_see_notifications_index_page(): void
    {
        $user = make(User::class);

        $this->actingAs($user)
            ->get('/notifications')
            ->assertOk();
    }

    /**
     * resources/views/notificatons/index
     * @test
     * @return void
     */
    public function guest_cant_see_notifications_index_page(): void
    {
        $this->get('/notifications')
            ->assertRedirect('/login');
    }
}
