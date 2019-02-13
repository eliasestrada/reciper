<?php

namespace Tests\Feature\Views\Recipes;

use App\Jobs\DeleteFileJob;
use App\Models\Fav;
use App\Models\Feedback;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesShowPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function view_is_accessable(): void
    {
        $slug = create(Recipe::class)->slug;
        $this->get("/recipes/{$slug}")->assertViewIs('recipes.show')->assertOk();
    }

    /**
     * @author Cho
     * @test
     */
    public function user_can_report_recipe_by_sending_message(): void
    {
        $data = [
            'message' => str_random(40),
            'recipe_id' => 1,
        ];

        $this->post(action('Admin\FeedbackController@store'), $data);
        $this->assertDatabaseHas('feedback', $data);
    }

    /**
     * @author Cho
     * @test
     */
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

    /**
     * @author Cho
     * @test
     */
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

    /**
     * @author Cho
     * @test
     */
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

    /**
     * @author Cho
     * @test
     */
    public function auth_user_can_add_recipe_to_favs(): void
    {
        $user = create_user();

        $this->actingAs($user)
            ->post(action('WebApi\FavController@store', ['id' => 1]))
            ->assertOk()
            ->assertSeeText('active');

        $this->assertDatabaseHas('favs', [
            'recipe_id' => 1,
            'user_id' => $user->id,
        ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function auth_user_can_delete_recipe_from_favs(): void
    {
        $user = create_user();
        Fav::create(['user_id' => $user->id, 'recipe_id' => 1]);

        $this->actingAs($user)
            ->post(action('WebApi\FavController@store', ['id' => 1]))
            ->assertOk()
            ->assertDontSeeText('active');

        $this->assertDatabaseMissing('favs', [
            'recipe_id' => 1,
            'user_id' => $user->id,
        ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function user_can_like_and_dislikethe_recipe(): void
    {
        $this->actingAs($user = create_user())
            ->post('/likes/1')
            ->assertSeeText('active');

        $this->actingAs($user)
            ->post('/likes/1')
            ->assertSeeText('');
    }

    /**
     * @author Cho
     * @test
     */
    public function DeleteFileJob_dispached_after_making_request_to_download_ingredients(): void
    {
        $this->expectsJobs(DeleteFileJob::class);
        $this->post(action('Invokes\DownloadIngredientsController', [
            'recipe_id' => 1,
        ]));

        \Storage::delete('ingredients-' . date('d-m-Y H-i') . '.txt');
    }
}
