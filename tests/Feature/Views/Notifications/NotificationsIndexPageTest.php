<?php

namespace Tests\Feature\Views\Notifications;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NotificationsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function viewNotificationsIndexHasData(): void
    {
        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->get('/notifications')
            ->assertViewIs('notifications.index')
            ->assertViewHas('notifications');
    }

    /**
     * Test for notifications page. View: resources/views/notifications/index
     * @return void
     * @test
     */
    public function userCanSeeNotificationsIndexPage(): void
    {
        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->get('/notifications')
            ->assertOk();
    }

    /**
     * Test for notifications page. View: resources/views/notifications/index
     * @return void
     * @test
     */
    public function guestCantSeeNotificationsIndexPage(): void
    {
        $this->get('/notifications')
            ->assertRedirect('/login');
    }
}
