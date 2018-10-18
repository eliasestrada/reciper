<?php

namespace Tests\Feature\Views\Notifications;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NotificationsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))->get('/notifications')->assertViewIs('notifications.index')->assertOk();
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/notifications')->assertRedirect('/login');
    }
}
