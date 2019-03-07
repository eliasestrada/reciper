<?php

namespace Tests\Feature\Views;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DashboardPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
     public function page_redirect_user_to_his_profile(): void
     {
         $this->actingAs($user = create_user())->get('/dashboard')
             ->assertRedirect("/users/{$user->username}");
     }

    /**
     * @test
     */
     public function page_redirect_guest_to_home_page(): void
     {
         $this->get('/dashboard')->assertRedirect('/');
     }
}
