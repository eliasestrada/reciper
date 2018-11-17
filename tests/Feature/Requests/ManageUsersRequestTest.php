<?php

namespace Tests\Feature\Requests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ManageUsersRequestTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    /**
     * @author Cho
     */
    public function setUp()
    {
        parent::setUp();
        $this->user = create_user();
    }

    /**
     * @author Cho
     */
    public function tearDown(): void
    {
        $this->assertDatabaseMissing('ban', [
            'user_id' => $this->user->id,
        ]);
        parent::tearDown();
    }

    /**
     * @author Cho
     * @test
     */
    public function ban_days_field_is_required(): void
    {
        $this->actingAs(create_user('master'))
            ->put(action('Master\ManageUsersController@update', [
                'id' => $this->user->id,
            ]), [
                'message' => str_random(40),
            ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function ban_message_fiels_is_required(): void
    {
        $this->actingAs(create_user('master'))
            ->put(action('Master\ManageUsersController@update', [
                'id' => $this->user->id,
            ]), [
                'days' => 2,
                'message' => '',
            ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function ban_days_field_must_be_numeric(): void
    {
        $this->actingAs(create_user('master'))
            ->put(action('Master\ManageUsersController@update', [
                'id' => $this->user->id,
            ]), [
                'days' => 'gg',
                'message' => str_random(40),
            ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function ban_message_must_be_not_short(): void
    {
        $this->actingAs(create_user('master'))
            ->put(action('Master\ManageUsersController@update', [
                'id' => $this->user->id,
            ]), [
                'days' => 5,
                'message' => str_random(config('valid.feedback.ban.message.min') - 1),
            ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function ban_message_must_be_not_long(): void
    {
        $this->actingAs(create_user('master'))
            ->put(action('Master\ManageUsersController@update', [
                'id' => $this->user->id,
            ]), [
                'days' => 5,
                'message' => str_random(config('valid.feedback.ban.message.max') + 1),
            ]);
    }
}
