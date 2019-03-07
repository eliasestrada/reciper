<?php

namespace Tests\Feature\Requests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DisapproveRequestTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function tearDown(): void
    {
        $this->assertDatabaseMissing('recipes', [
            'id' => 1,
            _('ready') => 0,
        ]);
        parent::tearDown();
    }

    /**
     * @test
     */
    public function message_is_required(): void
    {
        $this->actingAs(create_user('admin'))
            ->post(action('Admin\ApproveController@disapprove', [
                'recipe' => 1,
                'message' => '',
            ]));
    }

    /**
     * @test
     */
    public function message_must_be_not_short(): void
    {
        $this->actingAs(create_user('admin'))
            ->post(action('Admin\ApproveController@disapprove', [
                'recipe' => 1,
                'message' => string_random(config('valid.approves.disapprove.message.min') - 1),
            ]));
    }

    /**
     * @test
     */
    public function message_must_be_not_long(): void
    {
        $this->actingAs(create_user('admin'))
            ->post(action('Admin\ApproveController@disapprove', [
                'recipe' => 1,
                'message' => string_random(config('valid.approves.disapprove.message.max') + 1),
            ]));
    }
}
