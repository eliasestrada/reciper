<?php

namespace Tests\Feature\Views\Admin\Approves;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Notifications\RecipeApprovedNotification;
use App\Notifications\RecipeCanceledNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminApprovesShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Models\Recipe $unapproved_recipe
     */
    private $unapproved_recipe;

    /**
     * @var \App\Models\User $admin
     */
    private $admin;

    /**
     * Setup the test environment
     * Creating admin and recipe with his id in approver_id column
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->admin = ($admin = create_user('admin'));
        $this->unapproved_recipe = create(Recipe::class, [
            _('published') => 0,
            _('approved') => 0,
            _('approver_id', true) => $admin->id,
        ]);
    }

    /**
     * @test
     */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get("/admin/approves/{$this->unapproved_recipe->slug}")
            ->assertRedirect('/');
    }

    /**
     * @test
     */
    public function view_is_accessable_by_any_admin(): void
    {
        $this->actingAs($this->admin)
            ->get("/admin/approves/{$this->unapproved_recipe->slug}")
            ->assertViewIs('admin.approves.show')
            ->assertOk();

        $this->actingAs(create_user('admin'))
            ->get("/admin/approves/{$this->unapproved_recipe->slug}")
            ->assertOk();
    }

    /**
     * @test
     */
    public function second_checker_cant_see_approve_and_disapprove_buttons(): void
    {
        $other_admin = create_user('admin');

        $this->actingAs($other_admin)
            ->get("/admin/approves/{$this->unapproved_recipe->slug}")
            ->assertDontSee('<i class="fas fa-thumbs-up right"></i>')
            ->assertDontSee('<i class="fas fa-thumbs-down right"></i>');
    }

    /**
     * @test
     */
    public function admin_approves_recipe_and_got_redirected_to_approved_recipe(): void
    {
        $this->actingAs($this->admin)
            ->post(action('Admin\ApproveController@approve', [
                'recipe' => $this->unapproved_recipe->slug,
            ]))
            ->assertRedirect("/recipes/{$this->unapproved_recipe->slug}");
    }

    /**
     * @test
     */
    public function notification_is_sent_after_approving_the_recipe(): void
    {
        $this->expectsNotification(
            $this->unapproved_recipe->user,
            RecipeApprovedNotification::class
        );

        $this->actingAs($this->admin)
            ->post(action('Admin\ApproveController@approve', [
                'recipe' => $this->unapproved_recipe->slug,
            ]));
    }

    /**
     * @test
     */
    public function notification_is_sent_after_canceling_the_recipe(): void
    {
        $this->expectsNotification(
            $this->unapproved_recipe->user,
            RecipeCanceledNotification::class
        );

        $this->actingAs($this->admin)
            ->post(action('Admin\ApproveController@disapprove', [
                'recipe' => $this->unapproved_recipe->slug,
                'message' => string_random(20),
            ]));
    }

    /**
     * @test
     */
    public function approver_id_column_changes_to_id_of_the_first_admin_who_is_cheking_the_recipe(): void
    {
        $recipe = create(Recipe::class, [
            _('approver_id', true) => 0,
            _('approved') => 0,
        ]);

        $this->actingAs($this->admin)->get("/admin/approves/{$recipe->slug}");
        $this->assertDatabaseHas('recipes', [
            'id' => $recipe->id,
            _('approver_id', true) => $this->admin->id,
        ]);
    }
}
