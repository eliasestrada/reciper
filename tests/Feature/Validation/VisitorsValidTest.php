<?php

namespace Tests\Feature\Validation;

use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class VisitorsValidTest extends TestCase
{
    use DatabaseTransactions;

    private $msg_min;
    private $msg_max;
    private $visitor;
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->msg_min = config('validation.ban_message_min');
        $this->msg_max = config('validation.ban_message_max');
        $this->visitor = create(Visitor::class);
        $this->request = $this->actingAs(create_user('master'))->followingRedirects();
    }

    /** @test */
    public function ban_days_field_is_required(): void
    {
        $data = ['days' => '', 'message' => str_random(40)];

        $this->request
            ->put(action('Master\VisitorsController@update', ['id' => $this->visitor->id]), $data)
            ->assertSeeText(trans('visitors.days_required'));

        $this->assertDatabaseMissing('ban', $data);
    }

    /** @test */
    public function ban_message_fiels_is_required(): void
    {
        $data = ['days' => 2, 'message' => ''];

        $this->request
            ->put(action('Master\VisitorsController@update', ['id' => $this->visitor->id]), $data)
            ->assertSeeText(trans('visitors.message_required'));

        $this->assertDatabaseMissing('ban', $data);
    }

    /** @test */
    public function ban_days_field_must_be_numeric(): void
    {
        $data = ['days' => 'gg', 'message' => str_random(40)];

        $this->request
            ->put(action('Master\VisitorsController@update', ['id' => $this->visitor->id]), $data)
            ->assertSeeText(trans('visitors.days_numeric'));

        $this->assertDatabaseMissing('ban', $data);
    }

    /** @test */
    public function ban_message_must_be_not_short(): void
    {
        $data = ['days' => 5, 'message' => str_random($this->msg_min - 1)];

        $this->request
            ->put(action('Master\VisitorsController@update', ['id' => $this->visitor->id]), $data)
            ->assertSeeText(preg_replace('/:min/', $this->msg_min, trans('visitors.message_min')));

        $this->assertDatabaseMissing('ban', $data);
    }

    /** @test */
    public function ban_message_must_be_not_long(): void
    {
        $data = ['days' => 5, 'message' => str_random($this->msg_max + 1)];

        $this->request
            ->put(action('Master\VisitorsController@update', ['id' => $this->visitor->id]), $data)
            ->assertSeeText(preg_replace('/:max/', $this->msg_max, trans('visitors.message_max')));

        $this->assertDatabaseMissing('ban', $data);
    }
}
