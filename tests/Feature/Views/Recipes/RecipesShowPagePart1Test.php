<?php

namespace Tests\Feature\Views\Recipes;

use App\Models\Feedback;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesShowPagePart1Test extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $recipe = create(Recipe::class);

        $this->get("/recipes/$recipe->id")
            ->assertViewIs('recipes.show')
            ->assertViewHas('recipe');
    }

    /** @test */
    public function guest_can_see_the_page(): void
    {
        $this->get('/recipes/' . make(Recipe::class)->id)->assertOk();
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
    public function admin_can_approve_recipe_with_message(): void
    {
        $admin = create_user('admin');
        $unapproved_recipe = create(Recipe::class, ['approved_' . LANG => 0]);

        $this->actingAs($admin)
            ->get("/recipes/$unapproved_recipe->id");

        // Make request to approve a recipe with message
        $this->actingAs($admin)
            ->post(action('Admin\ApprovesController@approve',
                ['recipe_id' => $unapproved_recipe->id]),
                ['message' => str_random(30)])
            ->assertRedirect("/recipes/$unapproved_recipe->id");

        // Now recipe should be approved
        $this->assertDatabaseHas('recipes', [
            'id' => $unapproved_recipe->id,
            'approved_' . LANG => 1,
        ]);
    }

    /** @test */
    public function admin_can_disapprove_recipe_with_message(): void
    {
        $admin = create_user('admin');
        $unapproved_recipe = create(Recipe::class, ['approved_' . LANG => 0]);

        // Make request to disapprove a recipe with message
        $this->actingAs($admin)
            ->post(action('Admin\ApprovesController@disapprove', ['id' => $unapproved_recipe->id]), [
                'message' => str_random(40),
            ]);

        // Recipe should be still unapproved
        $this->assertDatabaseHas('recipes', [
            'id' => $unapproved_recipe->id,
            'approved_' . LANG => 0,
        ]);
    }

    /** @test */
    public function admin_cant_disapprove_recipe_without_message(): void
    {
        $admin = create_user('admin');
        $unapproved_recipe = create(Recipe::class, ['approved_' . LANG => 0]);

        $this->actingAs($admin)->get("/recipes/$unapproved_recipe->id");

        // Make request to disapprove a recipe with message
        $this->actingAs($admin)
            ->post(action('Admin\ApprovesController@disapprove', ['id' => $unapproved_recipe->id]))
            ->assertRedirect("/recipes/$unapproved_recipe->id");

        // Recipe should be still unapproved
        $this->assertDatabaseHas('recipes', [
            'id' => $unapproved_recipe->id,
            'approved_' . LANG => 0,
        ]);
    }

    /** @test */
    public function user_gets_notified_when_approved_his_recipe(): void
    {
        $admin = create_user('admin');
        $user = create(User::class);
        $recipe = create(Recipe::class, ['user_id' => $user->id, 'approved_' . LANG => 0]);

        $this->actingAs($admin)->get("/recipes/$recipe->id");

        // Make request to approve a recipe with message
        $this->actingAs($admin)
            ->post(action('Admin\ApprovesController@approve', ['id' => $recipe->id]))
            ->assertRedirect("/recipes/$recipe->id");

        // Now from user side
        $this->actingAs($user)
            ->get('/notifications')
            ->assertSeeText(trans('approves.recipe_published'));
    }

    /** @test */
    public function user_can_report_recipe_by_sending_message(): void
    {
        $data = [
            'message' => str_random(40),
            'recipe_id' => make(Recipe::class)->id,
        ];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSee(lang('feedback.success_message'));

        $this->assertDatabaseHas('feedback', $data);
    }

    /** @test */
    public function user_cant_report_same_recipe_twice_per_day(): void
    {
        $data = ['message' => str_random(40), 'recipe_id' => make(Recipe::class)->id];

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSee(lang('feedback.success_message'));
        $this->assertDatabaseHas('feedback', $data);

        // Changin message but recipe is the same
        $data['message'] = str_random(45);

        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSee(lang('feedback.already_reported_today'));
        $this->assertDatabaseMissing('feedback', $data);
    }

    /** @test */
    public function user_can_report_same_recipe_once_per_day(): void
    {
        $data = ['message' => str_random(40), 'recipe_id' => make(Recipe::class)->id];

        // First request
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSee(lang('feedback.success_message'));
        $this->assertDatabaseHas('feedback', $data);

        // Changing created_at field to minus day and changing message
        Feedback::latest()->first()->update(['created_at' => now()->subDay()]);
        $data['message'] = str_random(45);

        // Making another request (imitating the next day)
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data)
            ->assertSee(lang('feedback.success_message'));
        $this->assertDatabaseHas('feedback', $data);
    }

    /** @test */
    public function user_can_report_2_recipes_in_the_same_day(): void
    {
        $data1 = ['message' => str_random(40), 'recipe_id' => create(Recipe::class)->id];
        $data2 = ['message' => str_random(45), 'recipe_id' => create(Recipe::class)->id];

        // First report
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data1)
            ->assertSee(lang('feedback.success_message'));
        $this->assertDatabaseHas('feedback', $data1);

        // Second report
        $this->followingRedirects()
            ->post(action('Admin\FeedbackController@store'), $data2)
            ->assertSee(lang('feedback.success_message'));
        $this->assertDatabaseHas('feedback', $data2);
    }
}
