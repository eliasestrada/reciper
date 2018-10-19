<?php

namespace Tests\Feature\Views\Pages;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PagesContactPageTest extends TestCase
{
    use DatabaseTransactions;

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
        cache()->flush();
        $data = ['email' => 'test@emil.com', 'message' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit'];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(trans('feedback.success_message'));
        $this->assertDatabaseHas('feedback', $data);
    }

    /** @test */
    public function user_cant_send_feedback_message_more_then_once_per_day(): void
    {
        // First attempt to send a message, should be successful
        $first_data = ['email' => 'test@emil.com', 'message' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit'];
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $first_data)
            ->assertSeeText(trans('feedback.success_message'));
        $this->assertDatabaseHas('feedback', $first_data);

        // Second attempt to send a message, should be denied
        $second_data = ['email' => 'test@emil.com', 'message' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit'];
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $second_data)
            ->assertSeeText(trans('feedback.operation_denied'));
    }

    /** @test */
    public function user_can_send_message_after_a_day_since_the_last_message(): void
    {
        $first_data = ['email' => '11test@emil.com', 'message' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit'];
        $second_data = ['email' => 'testing@emil.com', 'message' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit'];

        // Make first request
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $first_data)
            ->assertSeeText(trans('feedback.success_message'));
        $this->assertDatabaseHas('feedback', $first_data);

        // Change created_at to minus day
        Feedback::latest()->first()->update(['created_at' => now()->subDay()]);

        // Make second request (imitating the next day)
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $second_data)
            ->assertSeeText(trans('feedback.success_message'));
        $this->assertDatabaseHas('feedback', $second_data);
    }
}
