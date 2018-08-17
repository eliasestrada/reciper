<?php

namespace Tests\Feature\Views\Pages;

use App\Models\Title;
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
    public function view_pages_home_has_data(): void
    {
        $responce = $this->get('/');

        $intro = Title::whereName("intro")->first([
            'title_' . lang(),
            'text_' . lang(),
        ]);

        $responce->assertViewIs('pages.home')
            ->assertViewHas('random_recipes')
            ->assertViewHas('intro', $intro);
    }

    /**
     * resources/views/pages/home
     * @test
     * @return void
     */
    public function auth_user_can_see_home_page(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get('/')->assertOk();
    }

    /**
     * resources/views/pages/home
     * @test
     * @return void
     */
    public function guest_can_see_home_page(): void
    {
        $this->get('/')->assertOk();
    }
}
