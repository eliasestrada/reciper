<?php

namespace Tests\Feature\Views\Pages;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/pages/home
     * @test
     * @return void
     */
    public function viewPagesHomeHasData(): void
    {
        $this->get('/')
            ->assertViewIs('pages.home')
            ->assertViewHasAll(['random_recipes', 'intro']);
    }

    /**
     * resources/views/pages/home
     * @test
     * @return void
     */
    public function authUserCanSeeHomePage(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get('/')->assertOk();
    }

    /**
     * resources/views/pages/home
     * @test
     * @return void
     */
    public function guestCanSeeHomePage(): void
    {
        $this->get('/')->assertOk();
    }
}
