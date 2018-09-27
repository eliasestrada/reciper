<?php

namespace Tests\Feature\Validation;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DisapproveValidTest extends TestCase
{
    use DatabaseTransactions;

    private $message_min;
    private $message_max;
    private $request;
    private $recipe;

    public function setUp()
    {
        parent::setUp();
        $this->message_min = config('validation.disapprove_message_min');
        $this->message_max = config('validation.disapprove_message_max');
        $this->request = $this->actingAs($admin = create_user('admin'))->followingRedirects();

        $this->recipe = create(Recipe::class, [
            'approved_' . lang() => 0,
            lang() . '_approver_id' => $admin->id,
        ]);
    }

    /** @test */
    public function message_must_be_not_short(): void
    {
        $this->request->post(action('Admin\ApprovesController@disapprove', [
            'recipe' => $this->recipe->id,
            'message' => str_random($this->message_min - 1),
        ]))->assertSeeText(preg_replace('/:min/', $this->message_min, trans('approves.message_min')));
    }
}
