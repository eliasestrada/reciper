<?php

namespace Tests\Feature\Requests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ManageUsersRequestTest extends TestCase
{
    use DatabaseTransactions;

    private $msg_min;
    private $msg_max;
    private $user;
    private $request;

    /**
     * @author Cho
     */
    public function setUp()
    {
        parent::setUp();
        $this->msg_min = config('valid.feedback.ban.message.min');
        $this->msg_max = config('valid.feedback.ban.message.max');
        $this->user = make(User::class, ['id' => 1]);
        $this->request = $this->actingAs(create_user('master'))->followingRedirects();
    }

    /**
     * @author Cho
     * @test
     */
    public function ban_days_field_is_required(): void
    {
        $this->request->put(action('Master\ManageUsersController@update', ['id' => $this->user->id]), [
            'message' => str_random(40),
        ])->assertSeeText(trans('manage-users.days_required'));
    }

    /**
     * @author Cho
     * @test
     */
    public function ban_message_fiels_is_required(): void
    {
        $this->request->put(action('Master\ManageUsersController@update', ['id' => $this->user->id]), [
            'days' => 2,
            'message' => '',
        ])->assertSeeText(trans('manage-users.message_required'));
    }

    /**
     * @author Cho
     * @test
     */
    public function ban_days_field_must_be_numeric(): void
    {
        $this->request->put(action('Master\ManageUsersController@update', ['id' => $this->user->id]), [
            'days' => 'gg',
            'message' => str_random(40),
        ])->assertSeeText(trans('manage-users.days_numeric'));
    }

    /**
     * @author Cho
     * @test
     */
    public function ban_message_must_be_not_short(): void
    {
        $this->request->put(action('Master\ManageUsersController@update', ['id' => $this->user->id]), [
            'days' => 5,
            'message' => str_random($this->msg_min - 1),
        ])->assertSeeText(preg_replace('/:min/', $this->msg_min, trans('manage-users.message_min')));
    }

    /**
     * @author Cho
     * @test
     */
    public function ban_message_must_be_not_long(): void
    {
        $this->request->put(action('Master\ManageUsersController@update', ['id' => $this->user->id]), [
            'days' => 5,
            'message' => str_random($this->msg_max + 1),
        ])->assertSeeText(preg_replace('/:max/', $this->msg_max, trans('manage-users.message_max')));
    }
}
