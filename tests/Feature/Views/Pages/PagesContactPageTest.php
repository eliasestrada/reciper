<?php

namespace Tests\Feature\Views\Pages;

use Tests\TestCase;
use App\Models\Feedback;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesContactPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function view_is_accessable(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertViewIs('pages.contact');
    }

    /**
     * @author Cho
     * @test
     */
    public function anyone_can_send_feedback_message(): void
    {
        $this->post(action('FeedbackController@store'), $data = [
            'email' => 'test@emil.com',
            'message' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit',
        ]);
        $this->assertDatabaseHas('feedback', $data);
    }

    /**
     * @author Cho
     * @test
     */
    public function user_cant_send_feedback_message_more_then_once_per_day(): void
    {
        $first_data = ['email' => 'test@emil.com', 'message' => string_random(20)];
        $second_data = ['email' => 'test2@emil.com', 'message' => string_random(20)];

        // First attempt to send a message, should be successful
        $this->post(action('FeedbackController@store'), $first_data);
        $this->assertDatabaseHas('feedback', $first_data);

        // Second attempt to send a message, should be denied
        $this->post(action('FeedbackController@store'), $second_data);
        $this->assertDatabaseMissing('feedback', $second_data);
    }

    /**
     * @author Cho
     * @test
     */
    public function user_can_send_message_after_a_day_since_the_last_message(): void
    {
        $first_data = ['email' => '11test@emil.com', 'message' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit'];
        $second_data = ['email' => 'testing@emil.com', 'message' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit'];

        // Make first request
        $this->post(action('FeedbackController@store'), $first_data);
        $this->assertDatabaseHas('feedback', $first_data);

        // Change created_at to minus day
        Feedback::latest()->first()->update(['created_at' => now()->subDay()]);

        // Make second request (imitating the next day)
        $this->post(action('FeedbackController@store'), $second_data);
        $this->assertDatabaseHas('feedback', $second_data);
    }
}
