<?php

namespace Tests\Feature\Views\Pages;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_pages_contact_has_a_correct_path(): void
    {
        $this->get('/contact')->assertViewIs('pages.contact');
    }

    /** @test */
    public function auth_user_can_see_contact_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/contact')
            ->assertOk();
    }

    /** @test */
    public function guest_can_see_contact_page(): void
    {
        $this->get('/contact')->assertOk();
    }

    /** @test */
    public function anyone_can_send_feedback_message(): void
    {
        $data = [
            'email' => 'johndoe@gmail.com',
            'message' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo, ipsa puhrar? Lorem ipsum dolor sit amet ahmet.',
        ];

        $this->followingRedirects()
            ->post(action('ContactController@store'), $data)
            ->assertSeeText(trans('admin.thanks_for_feedback'));

        $this->assertDatabaseHas('feedback', $data);
    }
}
