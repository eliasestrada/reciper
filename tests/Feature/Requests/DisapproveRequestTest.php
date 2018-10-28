<?php

namespace Tests\Feature\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DisapproveRequestTest extends TestCase
{
    use DatabaseTransactions;

    private $message_min;
    private $message_max;
    private $request;

    /**
     * @author Cho
     */
    public function setUp()
    {
        parent::setUp();
        $this->message_min = config('valid.approves.disapprove.message.min');
        $this->message_max = config('valid.approves.disapprove.message.max');

        $this->actingAs($admin = create_user('admin'))->get('/admin/approves');
        $this->request = $this->actingAs($admin)->followingRedirects();
    }

    /**
     * @author Cho
     * @test
     */
    public function message_is_required(): void
    {
        $this->request->post(action('Admin\ApprovesController@disapprove', [
            'recipe' => 1,
            'message' => '',
        ]))->assertSeeText(trans('approves.message_required'));
    }

    /**
     * @author Cho
     * @test
     */
    public function message_must_be_not_short(): void
    {
        $this->request->post(action('Admin\ApprovesController@disapprove', [
            'recipe' => 1,
            'message' => str_random($this->message_min - 1),
        ]))->assertSeeText(preg_replace('/:min/', $this->message_min, trans('approves.message_min')));
    }

    /**
     * @author Cho
     * @test
     */
    public function message_must_be_not_long(): void
    {
        $this->request->post(action('Admin\ApprovesController@disapprove', [
            'recipe' => 1,
            'message' => str_random($this->message_max + 1),
        ]))->assertSeeText(preg_replace('/:max/', $this->message_max, trans('approves.message_max')));
    }
}
