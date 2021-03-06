<?php

namespace Tests\Feature\Views\Recipes;

use Queue;
use Tests\TestCase;
use App\Models\Recipe;
use App\Jobs\DeleteFileJob;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipesEditPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function user_can_see_the_page_if_its_his_recipe(): void
    {
        $user = create_user();
        $slug = create(Recipe::class, ['user_id' => $user->id], null, 'draft')->slug;

        $this->actingAs($user)
            ->get("/recipes/{$slug}/edit")
            ->assertOk()
            ->assertViewIs('recipes.edit');
    }

    /**
     * @test
     */
    public function guest_cant_see_the_page(): void
    {
        $recipe = create(Recipe::class);
        $this->get("/recipes/{$recipe->slug}/edit")->assertRedirect();
    }

    /**
     * @test
     */
    public function not_author_of_the_recipe_cant_see_the_page(): void
    {
        $slug = create(Recipe::class)->slug;

        $this->actingAs(create_user())
            ->get("/recipes/{$slug}/edit")
            ->assertRedirect();
    }

    /**
     * @test
     */
    public function recipe_is_ready_but_not_approved_after_publishing_by_user(): void
    {
        $user = create_user();
        $recipe = create(Recipe::class, ['user_id' => $user->id], null, 'draft');
        $form_data = $this->form_data();

        $this->actingAs($user)
            ->put(action('RecipeController@update', $recipe->slug), $form_data)
            ->assertRedirect('/users/other/my-recipes');

        $this->assertDatabaseHas('recipes', [
            _('title') => $form_data['title'],
            _('ready') => 1,
            _('approved') => 0,
            'user_id' => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function recipe_can_be_saved(): void
    {
        $form_data = $this->form_data(['ready' => 0]);
        $user = create_user();
        $recipe = create(Recipe::class, ['user_id' => $user->id], null, 'draft');

        $this->actingAs($user)
            ->put(action('RecipeController@update', $recipe->slug), $form_data);

        $this->assertDatabaseHas('recipes', [
            'id' => $recipe->id,
            _('ready') => 0,
            _('approved') => 0,
            'user_id' => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function recipe_can_be_previewed(): void
    {
        $form_data = $this->form_data(['ready' => 0, 'view' => 1]);
        $user = create_user();
        $recipe = create(Recipe::class, ['user_id' => $user->id], null, 'draft');

        $this->actingAs($user)
            ->put(action('RecipeController@update', $recipe->slug), $form_data)
            ->assertRedirect("/recipes/{$recipe->slug}");
    }

    /**
     * @test
     */
    public function recipe_is_ready_and_approved_after_publishing_by_admin(): void
    {
        $admin = create_user('admin');
        $recipe = create(Recipe::class, ['user_id' => $admin->id], null, 'draft');
        $form_data = $this->form_data();

        $this->actingAs($admin)
            ->put(action('RecipeController@update', $recipe->slug), $form_data)
            ->assertRedirect('/users/other/my-recipes');

        $this->assertDatabaseHas('recipes', [
            _('title') => $form_data['title'],
            _('ready') => 1,
            _('approved') => 1,
            'user_id' => $admin->id,
        ]);
    }

    /**
     * @test
     */
    public function recipe_can_be_moved_to_drafts_by_author(): void
    {
        $author = create_user();
        $recipe = create(Recipe::class, ['user_id' => $author->id]);

        $this->actingAs($author)
            ->put(action('RecipeController@update', ['recipe' => $recipe->slug]));

        $this->assertDatabaseHas('recipes', [
            'id' => $recipe->id,
            _('approved') => 0,
            _('ready') => 0,
            'user_id' => $author->id,
        ]);
    }

    /**
     * @test
     */
    public function recipe_cant_be_moved_to_drafts_by_other_users(): void
    {
        $recipe = create(Recipe::class);

        $this->actingAs(create_user())
            ->put(action('RecipeController@update', ['recipe' => $recipe->slug]));

        $this->assertDatabaseHas('recipes', [
            'id' => $recipe->id,
            _('approved') => 1,
            _('ready') => 1,
        ]);
    }

    /**
     * @test
     */
    public function first_user_gets_notified_when_someone_uses_script_tags_in_fields(): void
    {
        $form_data = $this->form_data([
            'ready' => 0,
            'text' => '<script>',
        ]);

        $recipe = create(Recipe::class, [
            'user_id' => ($user = create_user())->id,
        ], null, 'draft');

        $this->actingAs($user)->get("/recipes/{$recipe->slug}/edit");
        $this->actingAs($user)
            ->followingRedirects()
            ->put(action('RecipeController@update', $recipe->slug), $form_data)
            ->assertSeeText(trans('notifications.cant_use_script_tags'));
    }

    /**
     * @test
     */
    public function user_can_upload_recipe_image(): void
    {
        $user = create_user();
        $recipe = create(Recipe::class, ['user_id' => $user->id], null, 'draft');

        $this->actingAs($user)
            ->put(action('RecipeController@update', ['recipe' => $recipe->slug]), [
                'image' => UploadedFile::fake()->image('image.jpg'),
            ]);

        $image_name = Recipe::whereId($recipe->id)->value('image');

        $this->assertNotEquals('default.jpg', $image_name);

        array_map(function ($dir) use ($image_name) {
            $this->assertFileExists(storage_path("app/public/{$dir}/recipes/{$image_name}"));
        }, ['big', 'small']);

        $this->cleanAfterYourself($image_name);
    }

    /**
     * @test
     */
    public function changing_recipe_image_user_dispaches_job_DeleteFileJob(): void
    {
        Queue::fake();

        $recipe = create(Recipe::class, [
            'user_id' => ($user = create_user())->id,
            'image' => 'image_name.jpg',
        ], null, 'draft');

        $this->actingAs($user)
            ->put(action('RecipeController@update', ['recipe' => $recipe->slug]), [
                'image' => UploadedFile::fake()->image('image.jpg'),
            ]);

        Queue::assertPushed(DeleteFileJob::class);
        $this->cleanAfterYourself(Recipe::whereId($recipe->id)->value('image'));
    }

    /**
     * @test
     */
    public function if_no_image_profided_DeleteFileJob_is_not_queued(): void
    {
        Queue::fake();

        $recipe = create(Recipe::class, [
            'user_id' => ($user = create_user())->id,
        ], null, 'draft');

        $this->actingAs($user)->put(action('RecipeController@update', [
            'recipe' => $recipe->slug
        ]));

        Queue::assertNotPushed(DeleteFileJob::class);
    }

    /**
     * @test
     */
    public function DeleteFileJob_is_dispached_when_recipe_is_deleted(): void
    {
        Queue::fake();

        $recipe = create(Recipe::class, [
            'user_id' => ($user = create_user())->id,
            'image' => 'just_image.jpg',
        ]);

        $this->actingAs($user)->delete(action('RecipeController@destroy', [
            'recipe' => $recipe->slug,
        ]));

        Queue::assertPushed(DeleteFileJob::class);
    }

    /**
     * @test
     */
    public function user_can_delete_his_recipe_from_DB(): void
    {
        $user = create_user();
        $recipe = create(Recipe::class, ['user_id' => $user->id], null, 'draft');

        $this->withoutJobs();
        $this->actingAs($user)->delete("/recipes/{$recipe->slug}");
        $this->assertDatabaseMissing('recipes', ['id' => $recipe->id]);
    }

    /**
     * @test
     */
    public function user_cant_delete_other_recipe_from_DB(): void
    {
        $recipe = create(Recipe::class, [], null, 'draft');

        $this->withoutJobs();
        $this->actingAs(create_user())->delete("/recipes/{$recipe->id}");
        $this->assertDatabaseHas('recipes', ['id' => $recipe->id]);
    }

    /**
     * Function helper
     *
     * @param array $new_value
     * @return array
     */
    public function form_data(array $new_value = []): array
    {
        $result = [
            'title' => string_random(20),
            'time' => 120,
            'meal' => 1,
            'ready' => 1,
            'ingredients' => string_random(50),
            'intro' => string_random(100),
            'text' => string_random(200),
            'image' => '',
            'categories' => [0 => 2, 1 => 3],
        ];

        if (!empty($new_value)) {
            foreach ($new_value as $key => $value) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Helper function
     * @param string $image_path
     * @return void
     */
    private function cleanAfterYourself(string $image_path): void
    {
        \Storage::delete([
            "public/big/recipes/{$image_path}",
            "public/small/recipes/{$image_path}",
        ]);
    }
}
