<?php

namespace Tests\Feature\Requests;

use Tests\TestCase;

class FeedbackRequestTest extends TestCase
{
    /**
     * @var int
     */
    private $msg_min;

    /**
     * @var int
     */
    private $msg_max;

    /**
     * Setup the test environment
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->msg_min = config('valid.feedback.contact.message.min');
        $this->msg_max = config('valid.feedback.contact.message.max');
        $this->get('/contact');
    }

    /**
     * @test
     */
    public function contact_message_is_required(): void
    {
        $data = ['email' => 'johntest@mail.ru', 'message' => ''];

        $this->followingRedirects()
            ->post(action('FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_message_required'));
    }

    /**
     * @test
     */
    public function contact_email_is_required(): void
    {
        $data = ['email' => '', 'message' => string_random(50)];

        $this->followingRedirects()
            ->post(action('FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_email_required'));
    }

    /**
     * @test
     */
    public function email_should_be_email_format(): void
    {
        $data = ['email' => 'testing@@mail', 'message' => string_random(50)];

        $this->followingRedirects()
            ->post(action('FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_email_email'));
    }

    /**
     * @test
     */
    public function message_has_to_be_not_short(): void
    {
        $data = [
            'email' => 'other@email.com',
            'message' => string_random($this->msg_min - 1),
        ];

        $this->followingRedirects()
            ->post(action('FeedbackController@store'), $data)
            ->assertSeeText(preg_replace('/:min/', $this->msg_min, trans('contact.contact_message_min')));
    }

    /**
     * @test
     */
    public function message_has_to_be_not_long(): void
    {
        $data = [
            'email' => 'somerandom@gmail.com',
            'message' => string_random($this->msg_max + 1),
        ];

        $this->followingRedirects()
            ->post(action('FeedbackController@store'), $data)
            ->assertSeeText(preg_replace('/:max/', $this->msg_max, trans('contact.contact_message_max')));
    }

    /**
     * @test
     */
    public function recipe_id_field_must_be_integer(): void
    {
        $data = ['message' => string_random(50), 'recipe_id' => 'h'];
        $this->post(action('FeedbackController@store'), $data);
        $this->assertDatabaseMissing('feedback', $data);
    }

    /**
     * @test
     */
    public function message_field_required_even_with_recipe_id_field(): void
    {
        $data = ['message' => '', 'recipe_id' => 3];
        $this->followingRedirects()
            ->post(action('FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_message_required'));
    }
}
