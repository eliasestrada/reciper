<?php

namespace Tests\Feature\Views\Recipes;

use App\Models\Feedback;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesShowPageTest extends TestCase
{
    use DatabaseTransactions;

    protected $admin;
    protected $recipe;
    protected $unapproved_recipe;

    public function setUp()
    {
        parent::setUp();

        $this->admin = create_user('admin');
        $this->recipe = make(Recipe::class);
        $this->unapproved_recipe = create(Recipe::class, [
            'approved_' . lang() => 0,
        ]);
    }

    /** @test */
    public function view_has_data(): void
    {
        $recipe = create(Recipe::class);

        $this->get("/recipes/$recipe->id")
            ->assertViewIs('recipes.show')
            ->assertViewHas('recipe');
    }

    /** @test */
    public function auth_user_can_see_the_page(): void
    {
        $user = make(User::class);
        $user2 = make(User::class);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);
        $recipe2 = make(Recipe::class, ['user_id' => $user2->id]);

        $this->actingAs($user)->get("/recipes/$recipe->id")->assertOk();
        $this->actingAs($user2)->get("/recipes/$recipe->id")->assertOk();
    }

    /** @test */
    public function guest_can_see_the_page(): void
    {
        $this->get("/recipes/{$this->recipe->id}")->assertOk();
    }

    /** @test */
    public function admin_can_approve_recipe_with_message(): void
    {
        $this->actingAs($this->admin)
            ->get("/recipes/{$this->unapproved_recipe->id}");

        // Make request to approve a recipe with message
        $this->actingAs($this->admin)
            ->post(action('Admin\ApprovesController@ok',
                ['recipe' => $this->unapproved_recipe->id]),
                ['message' => 'Lorem ipsum dolor sit amet consectetur han'])
            ->assertRedirect("/recipes/{$this->unapproved_recipe->id}");

        // Now recipe should be approved
        $this->assertDatabaseHas('recipes', [
            'id' => $this->unapproved_recipe->id,
            'approved_' . lang() => 1,
        ]);
    }

    /** @test */
    public function admin_can_cancel_recipe_with_message(): void
    {
        // Make request to cancel a recipe with message
        $this->actingAs($this->admin)
            ->post(action('Admin\ApprovesController@cancel',
                ['recipe' => $this->unapproved_recipe->id]),
                ['message' => 'Lorem ipsum dolor sit amet consectetur']
            );

        // Recipe should be still unapproved
        $this->assertDatabaseHas('recipes', [
            'id' => $this->unapproved_recipe->id,
            'approved_' . lang() => 0,
        ]);
    }

    /** @test */
    public function admin_cant_cancel_recipe_without_message(): void
    {
        $this->actingAs($this->admin)
            ->get("/recipes/{$this->unapproved_recipe->id}");

        // Make request to cancel a recipe with message
        $this->actingAs($this->admin)
            ->post(action('Admin\ApprovesController@cancel', [
                'recipe' => $this->unapproved_recipe->id,
            ]))
            ->assertRedirect("/recipes/{$this->unapproved_recipe->id}");

        // Recipe should be still unapproved
        $this->assertDatabaseHas('recipes', [
            'id' => $this->unapproved_recipe->id,
            'approved_' . lang() => 0,
        ]);
    }

    /** @test */
    public function user_gets_notified_when_approved_his_recipe(): void
    {
        $user = create(User::class);
        $recipe = create(Recipe::class, [
            'user_id' => $user->id,
            'approved_' . lang() => 0,
        ]);

        $this->actingAs($this->admin)
            ->get("/recipes/$recipe->id");

        // Make request to approve a recipe with message
        $this->actingAs($this->admin)
            ->post(action('Admin\ApprovesController@ok', ['id' => $recipe->id]))
            ->assertRedirect("/recipes/$recipe->id");

        // Now from user side
        $this->actingAs($user)
            ->get('/notifications')
            ->assertSeeText(trans('notifications.recipe_published'));
    }

    /** @test */
    public function user_can_report_recipe_by_sending_message(): void
    {
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), [
                'message' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
                'recipe' => $this->recipe->id,
            ])
            ->assertSee(lang('feedback.success_message'));
    }

    /** @test */
    public function user_cant_report_same_recipe_twice_per_day(): void
    {
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), [
                'message' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                'recipe' => $this->recipe->id,
            ])
            ->assertSee(lang('feedback.success_message'));

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), [
                'message' => 'Lorem ipsum dolor sit amet consectetur adipisicing elitic same',
                'recipe' => $this->recipe->id,
            ])
            ->assertSee(lang('feedback.already_reported_today'));
    }

    /** @test */
    public function user_can_report_same_recipe_once_per_day(): void
    {
        // First request
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), [
                'message' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit!!',
                'recipe' => $this->recipe->id,
            ])
            ->assertSee(lang('feedback.success_message'));

        // Changing created_at field to minus day
        Feedback::latest()->first()->update(['created_at' => now()->subDay()]);

        // Making another request (imitating the next day)
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), [
                'message' => 'Lorem ipsum dolor, sit amet consectetur price',
                'recipe' => $this->recipe->id,
            ])
            ->assertSee(lang('feedback.success_message'));
    }

    /** @test */
    public function user_can_report_2_recipes_in_the_same_day(): void
    {
        // First report
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), [
                'message' => 'Lorem ipsum dolor, sit amet consectetur',
                'recipe' => $this->recipe->id,
            ])
            ->assertSee(lang('feedback.success_message'));

        // Second report
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), [
                'message' => 'Lorem ipsum dolor, sit amet consectetur',
                'recipe' => create(Recipe::class)->id,
            ])
            ->assertSee(lang('feedback.success_message'));
    }
}
