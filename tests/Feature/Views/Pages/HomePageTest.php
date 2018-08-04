<?php

namespace Tests\Feature\Views\Pages;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use DatabaseTransactions;

    /**
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
     * Test for home page. View: resources/views/pages/home
     * @return void
     * @test
     */
    public function authUserCanSeeHomePage(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get('/')->assertOk();
    }

    /**
     * Test for home page. View: resources/views/pages/home
     * @return void
     * @test
     */
    public function guestCanSeeHomePage(): void
    {
        $this->get('/')->assertOk();
    }
}
