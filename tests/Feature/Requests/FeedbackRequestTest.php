<?php

namespace Tests\Feature\Requests;

use Tests\TestCase;

class FeedbackRequestTest extends TestCase
{
    private $msg_min;
    private $msg_max;

    /**
     * @author Cho
     */
    public function setUp()
    {
        parent::setUp();
        $this->msg_min = config('valid.feedback.contact.message.min');
        $this->msg_max = config('valid.feedback.contact.message.max');
        $this->get('/contact');
    }

    /**
     * @author Cho
     * @test
     */
    public function contact_message_is_required(): void
    {
        $data = ['email' => 'johntest@mail.ru', 'message' => ''];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_message_required'));
    }

    /**
     * @author Cho
     * @test
     */
    public function contact_email_is_required(): void
    {
        $data = ['email' => '', 'message' => str_random(50)];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_email_required'));
    }

    /**
     * @author Cho
     * @test
     */
    public function email_should_be_email_format(): void
    {
        $data = ['email' => 'testing@mail', 'message' => str_random(50)];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_email_email'));
    }

    /**
     * @author Cho
     * @test
     */
    public function message_has_to_be_not_short(): void
    {
        $data = [
            'email' => 'other@email.com',
            'message' => str_random($this->msg_min - 1),
        ];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(preg_replace('/:min/', $this->msg_min, trans('contact.contact_message_min')));
    }

    /**
     * @author Cho
     * @test
     */
    public function message_has_to_be_not_long(): void
    {
        $data = [
            'email' => 'somerandom@gmail.com',
            'message' => str_random($this->msg_max + 1),
        ];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(preg_replace('/:max/', $this->msg_max, trans('contact.contact_message_max')));
    }

    /**
     * @author Cho
     * @test
     */
    public function recipe_id_field_must_be_integer(): void
    {
        $data = ['message' => str_random(50), 'recipe_id' => 'h'];
        $this->post(action('Admin\FeedbackController@store'), $data);
        $this->assertDatabaseMissing('feedback', $data);
    }

    /**
     * @author Cho
     * @test
     */
    public function message_field_required_even_with_recipe_id_field(): void
    {
        $data = ['message' => '', 'recipe_id' => 3];
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_message_required'));
    }
}
