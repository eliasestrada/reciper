<?php

namespace Tests\Feature\Views\Pages;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/pages/contact
     * @test
     * @return void
     */
    public function view_pages_contact_has_a_correct_path(): void
    {
        $this->get('/contact')->assertViewIs('pages.contact');
    }

    /**
     * resources/views/pages/contact
     * @test
     * @return void
     */
    public function auth_user_can_see_contact_page(): void
    {
        $this->actingAs(create(User::class))
            ->get('/contact')
            ->assertOk();
    }

    /**
     * resources/views/pages/contact
     * @test
     * @return void
     */
    public function guest_can_see_contact_page(): void
    {
        $this->get('/contact')->assertOk();
    }
}
