<?php

namespace Tests\Feature\Views\Pages;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use DatabaseTransactions;

    public $faker;

    public function setUp()
    {
        parent::setUp();
        $this->faker = \Faker\Factory::create();
    }

    /** @test */
    public function view_has_a_correct_path(): void
    {
        $this->get('/contact')->assertViewIs('pages.contact');
    }

    /** @test */
    public function auth_user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/contact')
            ->assertOk();
    }

    /** @test */
    public function guest_can_see_the_page(): void
    {
        $this->get('/contact')->assertOk();
    }

    /** @test */
    public function anyone_can_send_feedback_message(): void
    {
        $data = ['email' => $this->faker->safeEmail, 'message' => $this->faker->text];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(trans('feedback.success_message'));

        $this->assertDatabaseHas('feedback', $data);
    }

    /** @test */
    public function user_can_send_feedback_message_only_once_per_day(): void
    {
        // First attempt to send a message, should be successful
        $first_data = ['email' => $this->faker->safeEmail, 'message' => $this->faker->text];
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $first_data)
            ->assertSeeText(trans('feedback.success_message'));

        $this->assertDatabaseHas('feedback', $first_data);

        // Second attempt to send a message, should be denied
        $second_data = ['email' => $this->faker->safeEmail, 'message' => $this->faker->text];
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $second_data)
            ->assertSeeText(trans('feedback.operation_denied'));

        $this->assertDatabaseMissing('feedback', $second_data);
    }
}
