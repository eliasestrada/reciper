<?php

namespace Tests\Feature\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DisapproveRequestTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     */
    public function tearDown()
    {
        $this->assertDatabaseMissing('recipes', [
            'id' => 1,
            _('ready') => 0,
        ]);
        parent::tearDown();
    }

    /**
     * @author Cho
     * @test
     */
    public function message_is_required(): void
    {
        $this->actingAs(create_user('admin'))
            ->post(action('Admin\ApprovesController@disapprove', [
                'recipe' => 1,
                'message' => '',
            ]));
    }

    /**
     * @author Cho
     * @test
     */
    public function message_must_be_not_short(): void
    {
        $this->actingAs(create_user('admin'))
            ->post(action('Admin\ApprovesController@disapprove', [
                'recipe' => 1,
                'message' => str_random(config('valid.approves.disapprove.message.min') - 1),
            ]));
    }

    /**
     * @author Cho
     * @test
     */
    public function message_must_be_not_long(): void
    {
        $this->actingAs(create_user('admin'))
            ->post(action('Admin\ApprovesController@disapprove', [
                'recipe' => 1,
                'message' => str_random(config('valid.approves.disapprove.message.max') + 1),
            ]));
    }
}
