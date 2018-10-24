<?php

namespace Tests\Feature\Views\Recipes;

use App\Models\Fav;
use App\Models\Feedback;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_is_accessable(): void
    {
        $recipe_id = create(Recipe::class)->id;
        $this->get("/recipes/$recipe_id")->assertViewIs('recipes.show')->assertOk();
    }

    /** @test */
    public function user_can_report_recipe_by_sending_message(): void
    {
        $data = [
            'message' => str_random(40),
            'recipe_id' => 1,
        ];

        $this->post(action('Admin\FeedbackController@store'), $data);
        $this->assertDatabaseHas('feedback', $data);
    }

    /** @test */
    public function user_cant_report_same_recipe_twice_per_day(): void
    {
        $data = ['message' => str_random(40), 'recipe_id' => 1];

        $this->post(action('Admin\FeedbackController@store'), $data);
        $this->assertDatabaseHas('feedback', $data);

        // Changin message but recipe is the same
        $data['message'] = str_random(45);

        $this->post(action('Admin\FeedbackController@store'), $data);
        $this->assertDatabaseMissing('feedback', $data);
    }

    /** @test */
    public function user_can_report_same_recipe_once_per_day(): void
    {
        $data = ['message' => str_random(40), 'recipe_id' => 1];

        // First request
        $this->post(action('Admin\FeedbackController@store'), $data);
        $this->assertDatabaseHas('feedback', $data);

        // Changing created_at field to minus day and changing message
        Feedback::latest()->first()->update(['created_at' => now()->subDay()]);
        $data['message'] = str_random(45);

        // Making another request (imitating the next day)
        $this->post(action('Admin\FeedbackController@store'), $data);
        $this->assertDatabaseHas('feedback', $data);
    }

    /** @test */
    public function user_can_report_2_recipes_in_the_same_day(): void
    {
        $data1 = ['message' => str_random(40), 'recipe_id' => 1];
        $data2 = ['message' => str_random(45), 'recipe_id' => create(Recipe::class)->id];

        // First report
        $this->post(action('Admin\FeedbackController@store'), $data1);
        $this->assertDatabaseHas('feedback', $data1);

        // Second report
        $this->post(action('Admin\FeedbackController@store'), $data2);
        $this->assertDatabaseHas('feedback', $data2);
    }

    /** @test */
    public function owner_of_the_recipe_sees_report_button_disabled(): void
    {
        $user = create_user();
        $recipe = create(Recipe::class, ['user_id' => $user->id]);

        $this->actingAs($user)
            ->get("/recipes/$recipe->id")
            ->assertSee('<a href="#report-recipe-modal" class="btn waves-effect waves-light modal-trigger min-w" disabled>');
    }

    /** @test */
    public function auth_user_can_add_recipe_to_favs(): void
    {
        $user = create_user();

        $this->actingAs($user)
            ->post(action('FavsController@store', ['id' => 1]))
            ->assertOk()
            ->assertSeeText('active');

        $this->assertDatabaseHas('favs', [
            'recipe_id' => 1,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function auth_user_can_delete_recipe_from_favs(): void
    {
        $user = create_user();
        Fav::create(['user_id' => $user->id, 'recipe_id' => 1]);

        $this->actingAs($user)
            ->post(action('FavsController@store', ['id' => 1]))
            ->assertOk()
            ->assertDontSeeText('active');

        $this->assertDatabaseMissing('favs', [
            'recipe_id' => 1,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function visitor_can_like_the_recipe(): void
    {
        $this->post('/api/like/like/1')
            ->assertExactJson(['liked' => 1]);
    }

    /** @test */
    public function visitor_can_dislike_the_recipe(): void
    {
        $this->post('/api/like/like/1');
        $this->post('/api/like/dislike/1')
            ->assertExactJson(['liked' => 0]);
    }
}
