<?php

namespace Tests\Feature\Views\Pages;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function viewPagesContactHasACorrectPath(): void
    {
        $this->get('/contact')->assertViewIs('pages.contact');
    }

    /**
     * Test for contact page. View: resources/views/pages/contact
     * @return void
     * @test
     */
    public function authUserCanSeeContactPage(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get('/contact')->assertOk();
    }

    /**
     * Test for contact page. View: resources/views/pages/contact
     * @return void
     * @test
     */
    public function guestCanSeeContactPage(): void
    {
        $this->get('/contact')->assertOk();
    }
}
