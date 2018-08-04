<?php

namespace Tests\Feature\Views\Pages;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test for contact page. View: resources/views/pages/contact
     * @return void
     * @test
     */
    public function authUserCanSeeContactPage(): void
    {
        $this->actingAs(factory(User::class)->create())
            ->get('/contact')
            ->assertOk()
            ->assertViewIs('pages.contact');
    }

    /**
     * Test for contact page. View: resources/views/pages/contact
     * @return void
     * @test
     */
    public function guestCanSeeContactPage(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertViewIs('pages.contact');
    }
}
