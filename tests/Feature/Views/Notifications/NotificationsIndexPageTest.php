<?php

namespace Tests\Feature\Views\Notifications;

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
        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->get('/notifications')
            ->assertViewIs('notifications.index')
            ->assertViewHas('notifications');
    }

    /**
     * resources/views/notificatons/index
     * @test
     * @return void
     */
    public function user_can_see_notifications_index_page(): void
    {
        $user = factory(User::class)->make();

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
