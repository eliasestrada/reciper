<?php

namespace Tests\Feature\Requests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManageUsersRequestTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Models\User
     */
    private $user;

    /**
     * Setup the test environment
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = create_user();
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        $this->assertDatabaseMissing('ban', [
            'user_id' => $this->user->id,
        ]);
        parent::tearDown();
    }

    /**
     * @test
     */
    public function ban_days_field_is_required(): void
    {
        $this->actingAs(create_user('master'))
            ->put(action('Master\ManageUserController@update', [
                'id' => $this->user->id
            ]), ['message' => string_random(40)]);
    }

    /**
     * @test
     */
    public function ban_message_fiels_is_required(): void
    {
        $this->actingAs(create_user('master'))
            ->put(action('Master\ManageUserController@update', [
                'id' => $this->user->id,
            ]), ['days' => 2, 'message' => '']);
    }

    /**
     * @test
     */
    public function ban_days_field_must_be_numeric(): void
    {
        $this->actingAs(create_user('master'))
            ->put(action('Master\ManageUserController@update', [
                'id' => $this->user->id,
            ]), ['days' => 'gg', 'message' => string_random(40)]);
    }

    /**
     * @test
     */
    public function ban_message_must_be_not_short(): void
    {
        $this->actingAs(create_user('master'))
            ->put(action('Master\ManageUserController@update', [
                'id' => $this->user->id,
            ]), [
                'days' => 5,
                'message' => string_random(config('valid.feedback.ban.message.min') - 1),
            ]);
    }

    /**
     * @test
     */
    public function ban_message_must_be_not_long(): void
    {
        $this->actingAs(create_user('master'))
            ->put(action('Master\ManageUserController@update', [
                'id' => $this->user->id,
            ]), [
                'days' => 5,
                'message' => string_random(config('valid.feedback.ban.message.max') + 1),
            ]);
    }
}
