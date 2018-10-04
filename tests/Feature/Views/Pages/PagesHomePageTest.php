<?php

namespace Tests\Feature\Views\Pages;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PagesHomePageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $this->get('/')->assertViewIs('pages.home')->assertViewHas('random_recipes');
    }

    /** @test */
    public function auth_user_can_see_the_page(): void
    {
        $user = make(User::class);
        $this->actingAs($user)->get('/')->assertOk();
    }

    /** @test */
    public function guest_can_see_the_page(): void
    {
        $this->get('/')->assertOk();
    }
}
