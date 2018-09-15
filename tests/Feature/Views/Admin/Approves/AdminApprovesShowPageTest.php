<?php

namespace Tests\Feature\Views\Admin\Approves;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminApprovesShowPageTest extends TestCase
{
    use DatabaseTransactions;

    public $unapproved_recipe;
    public $admin;

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
            ->assertSee('<i class="material-icons right">thumb_up')
            ->assertSee('<i class="material-icons right">thumb_down');
    }

    /** @test */
    public function second_checker_cant_see_approve_and_cancel_buttons(): void
    {
        $other_admin = create_user('admin');

        $this->actingAs($other_admin)
            ->get("/admin/approves/{$this->unapproved_recipe->id}")
            ->assertDontSee('<i class="material-icons right">thumb_up')
            ->assertDontSee('<i class="material-icons right">thumb_down');
    }

    /** @test */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get("/admin/approves/{$this->unapproved_recipe->id}")
            ->assertRedirect('/');
    }
}