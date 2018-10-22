<?php

namespace Tests\Feature\Views\Recipes;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecipesEditPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $user = create_user();
        $recipe = create(Recipe::class, ['user_id' => $user->id], null, 'draft');

        $this->actingAs($user)
            ->get("/recipes/{$recipe->id}/edit")
            ->assertOk()
            ->assertViewIs('recipes.edit')
            ->assertViewHasAll(['meal', 'recipe']);
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $recipe = create(Recipe::class);
        $this->get("/recipes/$recipe->id/edit")->assertRedirect();
    }

    /** @test */
    public function not_author_of_the_recipe_cant_see_the_page(): void
    {
        $recipe = create(Recipe::class);

        $this->actingAs(create_user())
            ->get("/recipes/$recipe->id/edit")
            ->assertRedirect();
    }

    /** @test */
    public function recipe_is_ready_but_not_approved_after_publishing_by_user(): void
    {
        $user = create_user();
        $recipe = create(Recipe::class, ['user_id' => $user->id], null, 'draft');
        $form_data = $this->form_data();

        $this->actingAs($user)
            ->put(action('RecipesController@update', $recipe->id), $form_data)
            ->assertRedirect('/users/other/my-recipes');

        $this->assertDatabaseHas('recipes', [
            'title_' . LANG() => $form_data['title'],
            'ready_' . LANG() => 1,
            'approved_' . LANG() => 0,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function recipe_can_be_saved(): void
    {
        $form_data = $this->form_data(['ready' => 0]);
        $user = create_user();
        $recipe = create(Recipe::class, ['user_id' => $user->id], null, 'draft');

        $this->actingAs($user)
            ->put(action('RecipesController@update', $recipe->id), $form_data);

        $this->assertDatabaseHas('recipes', [
            'id' => $recipe->id,
            'ready_' . LANG() => 0,
            'approved_' . LANG() => 0,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function recipe_is_ready_and_approved_after_publishing_by_admin(): void
    {
        $admin = create_user('admin');
        $recipe = create(Recipe::class, ['user_id' => $admin->id], null, 'draft');
        $form_data = $this->form_data();

        $this->actingAs($admin)
            ->put(action('RecipesController@update', $recipe->id), $form_data)
            ->assertRedirect('/users/other/my-recipes');

        $this->assertDatabaseHas('recipes', [
            'title_' . LANG() => $form_data['title'],
            'ready_' . LANG() => 1,
            'approved_' . LANG() => 1,
            'user_id' => $admin->id,
        ]);
    }

    /** @test */
    public function recipe_can_be_moved_to_drafts_by_author(): void
    {
        $author = create_user();
        $recipe = create(Recipe::class, ['user_id' => $author->id]);

        $this->actingAs($author)
            ->put(action('RecipesController@update', ['recipe' => $recipe->id]));

        $this->assertDatabaseHas('recipes', [
            'id' => $recipe->id,
            'approved_' . LANG() => 0,
            'ready_' . LANG() => 0,
            'user_id' => $author->id,
        ]);
    }

    /** @test */
    public function recipe_cant_be_moved_to_drafts_by_other_users(): void
    {
        $recipe = create(Recipe::class);

        $this->actingAs(create_user())
            ->put(action('RecipesController@update', ['recipe' => $recipe->id]));

        $this->assertDatabaseHas('recipes', [
            'id' => $recipe->id,
            'approved_' . LANG() => 1,
            'ready_' . LANG() => 1,
        ]);
    }

    /** @test */
    public function first_user_gets_notified_when_someone_uses_script_tags_in_fields(): void
    {
        $form_data = $this->form_data([
            'ready' => 0,
            'text' => '<script>',
        ]);

        $recipe = create(Recipe::class, [
            'user_id' => ($user = create_user())->id,
        ], null, 'draft');

        $this->actingAs($user)
            ->followingRedirects()
            ->put(action('RecipesController@update', $recipe->id), $form_data)
            ->assertSeeText(trans('notifications.cant_use_script_tags'));
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
            'title' => str_random(20),
            'time' => 120,
            'meal' => 1,
            'ready' => 1,
            'ingredients' => str_random(50),
            'intro' => str_random(100),
            'text' => str_random(200),
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
}
