<?php

namespace Tests\Feature\Views\Admin\Approves;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminApprovesShowPageTest extends TestCase
{
    use DatabaseTransactions;

    private $unapproved_recipe;
    private $admin;

    /**
     * Creating admin and recipe with his id in approver_id column
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $admin = create_user('admin');

        $this->unapproved_recipe = create(Recipe::class, [
            'approved_' . lang() => 0,
            lang() . '_approver_id' => $admin->id,
        ]);

        $this->admin = $admin;
    }

    /** @test */
    public function view_has_data(): void
    {
        $this->actingAs($this->admin)
            ->get("/admin/approves/{$this->unapproved_recipe->id}")
            ->assertViewIs('admin.approves.show')
            ->assertViewHasAll([
                'recipe' => Recipe::whereId($this->unapproved_recipe->id)
                    ->with('approver')
                    ->with('categories')
                    ->with('views')
                    ->with('user')
                    ->first(),
                'approver_id' => $this->admin->id,
            ]);
    }

    /** @test */
    public function view_is_accessable_by_any_admin(): void
    {
        $this->actingAs($this->admin)
            ->get("/admin/approves/{$this->unapproved_recipe->id}")
            ->assertOk();

        $this->actingAs(create_user('admin'))
            ->get("/admin/approves/{$this->unapproved_recipe->id}")
            ->assertOk();
    }

    /** @test */
    public function first_checker_can_see_approve_and_cancel_buttons(): void
    {
        $this->actingAs($this->admin)
            ->get("/admin/approves/{$this->unapproved_recipe->id}")
            ->assertSee('<i class="fas fa-thumbs-up right"></i>')
            ->assertSee('<i class="fas fa-thumbs-down right"></i>');
    }

    /** @test */
    public function second_checker_cant_see_approve_and_disapprove_buttons(): void
    {
        $other_admin = create_user('admin');

        $this->actingAs($other_admin)
            ->get("/admin/approves/{$this->unapproved_recipe->id}")
            ->assertDontSee('<i class="fas fa-thumbs-up right"></i>')
            ->assertDontSee('<i class="fas fa-thumbs-down right"></i>');
    }

    /** @test */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get("/admin/approves/{$this->unapproved_recipe->id}")
            ->assertRedirect('/');
    }

    /** @test */
    public function admin_approves_recipe(): void
    {
        $this->actingAs($this->admin)
            ->followingRedirects()
            ->post(action('Admin\ApprovesController@approve', [
                'recipe' => $this->unapproved_recipe->id,
            ]))
            ->assertSee(trans('recipes.recipe_published'));
    }

    /** @test */
    public function admin_cant_cancel_publishing_recipe_with_short_message(): void
    {
        $this->actingAs($this->admin)
            ->followingRedirects()
            ->post(action('Admin\ApprovesController@disapprove', [
                'recipe' => $this->unapproved_recipe->id,
                'message' => 'No message',
            ]))
            ->assertDontSee(trans('recipes.recipe_published'));
    }
}
