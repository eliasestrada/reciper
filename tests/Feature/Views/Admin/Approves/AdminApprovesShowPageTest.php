<?php

namespace Tests\Feature\Views\Admin\Approves;

use App\Models\Recipe;
use App\Models\User;
use App\Notifications\RecipeApprovedNotification;
use App\Notifications\RecipeCanceledNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminApprovesShowPageTest extends TestCase
{
    use DatabaseTransactions;

    private $unapproved_recipe;
    private $admin;

    /**
     * Creating admin and recipe with his id in approver_id column
     * @author Cho
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->admin = ($admin = create_user('admin'));
        $this->unapproved_recipe = create(Recipe::class, [
            'approved_' . LANG() => 0,
            LANG() . '_approver_id' => $admin->id,
        ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get("/admin/approves/{$this->unapproved_recipe->id}")
            ->assertRedirect('/');
    }

    /**
     * @author Cho
     * @test
     */
    public function view_is_accessable_by_any_admin(): void
    {
        $this->actingAs($this->admin)
            ->get("/admin/approves/{$this->unapproved_recipe->id}")
            ->assertViewIs('admin.approves.show')
            ->assertOk();

        $this->actingAs(create_user('admin'))
            ->get("/admin/approves/{$this->unapproved_recipe->id}")
            ->assertOk();
    }

    /**
     * @author Cho
     * @test
     */
    public function second_checker_cant_see_approve_and_disapprove_buttons(): void
    {
        $other_admin = create_user('admin');

        $this->actingAs($other_admin)
            ->get("/admin/approves/{$this->unapproved_recipe->id}")
            ->assertDontSee('<i class="fas fa-thumbs-up right"></i>')
            ->assertDontSee('<i class="fas fa-thumbs-down right"></i>');
    }

    /**
     * @author Cho
     * @test
     */
    public function admin_approves_recipe_and_got_redirected_to_approved_recipe(): void
    {
        $this->actingAs($this->admin)
            ->post(action('Admin\ApprovesController@approve', [
                'recipe' => $this->unapproved_recipe->id,
            ]))
            ->assertRedirect("/recipes/{$this->unapproved_recipe->slug}");
    }

    /**
     * @author Cho
     * @test
     */
    public function notification_is_sent_after_approving_the_recipe(): void
    {
        $this->expectsNotification(
            $this->unapproved_recipe->user,
            RecipeApprovedNotification::class
        );

        $this->actingAs($this->admin)
            ->post(action('Admin\ApprovesController@approve', [
                'recipe' => $this->unapproved_recipe->id,
            ]));
    }

    /**
     * @author Cho
     * @test
     */
    public function notification_is_sent_after_canceling_the_recipe(): void
    {
        \Notification::fake();

        $this->actingAs($this->admin)
            ->post(action('Admin\ApprovesController@disapprove', [
                'recipe' => $this->unapproved_recipe->id,
                'message' => str_random(20),
            ]));

        \Notification::assertSentTo(
            [$this->unapproved_recipe->user],
            RecipeCanceledNotification::class
        );
    }

    /**
     * @author Cho
     * @test
     */
    public function approver_id_column_changes_to_id_of_the_first_admin_who_is_cheking_the_recipe(): void
    {
        $recipe = create(Recipe::class, [
            LANG() . '_approver_id' => 0,
            'approved_' . LANG() => 0,
        ]);

        $this->actingAs($this->admin)->get("/admin/approves/{$recipe->id}");
        $this->assertDatabaseHas('recipes', [
            'id' => $recipe->id,
            LANG() . '_approver_id' => $this->admin->id,
        ]);
    }
}
