<?php

namespace Tests\Feature\Validation;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ContactValidTest extends TestCase
{
    use DatabaseTransactions;

    private $message_min;
    private $message_max;

    public function setUp()
    {
        parent::setUp();
        $this->message_min = config('validation.contact_message_min');
        $this->message_max = config('validation.contact_message_max');
    }

    /** @test */
    public function message_is_required(): void
    {
        $data = ['email' => 'johntest@mail.ru', 'message' => ''];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_message_required'));

        $this->assertDatabaseMissing('feedback', $data);
    }

    /** @test */
    public function email_is_required(): void
    {
        $data = ['email' => '', 'message' => str_random(50)];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_email_required'));

        $this->assertDatabaseMissing('feedback', $data);
    }

    /** @test */
    public function email_should_be_email_format(): void
    {
        $data = ['email' => 'testing@mail', 'message' => str_random(50)];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_email_email'));

        $this->assertDatabaseMissing('feedback', $data);
    }

    /** @test */
    public function message_has_to_be_not_short(): void
    {
        $data = [
            'email' => 'other@email.com',
            'message' => str_random($this->message_min - 1),
        ];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSee(preg_replace('/:min/', $this->message_min, trans('contact.contact_message_min')));

        $this->assertDatabaseMissing('feedback', $data);
    }

    /** @test */
    public function message_has_to_be_not_long(): void
    {
        $data = [
            'email' => 'somerandom@gmail.com',
            'message' => str_random($this->message_max + 1),
        ];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSee(preg_replace('/:max/', $this->message_max, trans('contact.contact_message_max')));

        $this->assertDatabaseMissing('feedback', $data);
    }
}
