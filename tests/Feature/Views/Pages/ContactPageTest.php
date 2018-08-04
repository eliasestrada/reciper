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
    public function viewPagesContactHasACorrectPath(): void
    {
        $this->get('/contact')->assertViewIs('pages.contact');
    }

    /**
     * resources/views/pages/contact
     * @test
     * @return void
     */
    public function authUserCanSeeContactPage(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->get('/contact')->assertOk();
    }

    /**
     * resources/views/pages/contact
     * @test
     * @return void
     */
    public function guestCanSeeContactPage(): void
    {
        $this->get('/contact')->assertOk();
    }
}
