<?php

namespace Tests\Feature\Validation;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FeedbackValidTest extends TestCase
{
    use DatabaseTransactions;

    private $msg_min;
    private $msg_max;

    public function setUp()
    {
        parent::setUp();
        $this->msg_min = config('validation.contact_message_min');
        $this->msg_max = config('validation.contact_message_max');
    }

    /** @test */
    public function contact_message_is_required(): void
    {
        $data = ['email' => 'johntest@mail.ru', 'message' => ''];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_message_required'));
    }

    /** @test */
    public function contact_email_is_required(): void
    {
        $data = ['email' => '', 'message' => str_random(50)];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_email_required'));
    }

    /** @test */
    public function email_should_be_email_format(): void
    {
        $data = ['email' => 'testing@mail', 'message' => str_random(50)];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_email_email'));
    }

    /** @test */
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

    /** @test */
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

    /** @test */
    public function if_recipe_id_field_is_in_request_email_is_not_required(): void
    {
        $data = [
            'message' => str_random(50),
            'recipe_id' => create(Recipe::class)->id,
        ];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(trans('feedback.success_message'));
    }

    /** @test */
    public function recipe_id_field_must_be_integer(): void
    {
        $data = ['message' => str_random(50), 'recipe_id' => 'h'];
        $this->post(action('Admin\FeedbackController@store'), $data);
        $this->assertDatabaseMissing('feedback', $data);
    }

    /** @test */
    public function message_field_required_even_with_recipe_id_field(): void
    {
        $data = ['message' => '', 'recipe_id' => create(Recipe::class)->id];
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSeeText(trans('contact.contact_message_required'));
    }
}
