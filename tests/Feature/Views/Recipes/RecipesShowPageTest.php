<?php

namespace Tests\Feature\Views\Recipes;

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

        $this->admin = create(User::class, ['admin' => 1]);
        $this->recipe = create(Recipe::class);
        $this->unapproved_recipe = create(Recipe::class, [
            'approved_' . lang() => 0,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function view_recipes_show_has_data(): void
    {
        $this->get('/recipes/' . $this->recipe->id)
            ->assertViewIs('recipes.show')
            ->assertViewHas('recipe',
                Recipe::with('likes', 'categories', 'user')
                    ->whereId($this->recipe->id)
                    ->first()
            );
    }

    /**
     * @test
     * @return void
     */
    public function auth_user_can_see_recipe_show_page(): void
    {
        $user = create(User::class);
        $user2 = create(User::class);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);
        $recipe2 = make(Recipe::class, ['user_id' => $user2->id]);

        $this->actingAs($user)->get("/recipes/$recipe->id")->assertOk();
        $this->actingAs($user2)->get("/recipes/$recipe->id")->assertOk();
    }

    /**
     * @test
     * @return void
     */
    public function guest_can_see_recipes_show_page(): void
    {
        $this->get("/recipes/{$this->recipe->id}")->assertOk();
    }

    /**
     * @test
     * @return void
     */
    public function admin_can_approve_recipe_with_message(): void
    {
        $this->actingAs($this->admin)
            ->get("/recipes/{$this->unapproved_recipe->id}");

        // Make request to approve a recipe with message
        $this->actingAs($this->admin)
            ->post(action('ApproveController@ok',
                ['recipe' => $this->unapproved_recipe->id]),
                ['message' => 'Lorem ipsum dolor sit amet consectetur han'])
            ->assertRedirect('/recipes');

        // Now recipe should be approved
        $this->assertDatabaseHas('recipes', [
            'id' => $this->unapproved_recipe->id,
            'approved_' . lang() => 1,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function admin_cant_approve_recipe_without_message(): void
    {
        $this->actingAs($this->admin)
            ->get("/recipes/{$this->unapproved_recipe->id}");

        // Make request to approve a recipe without message
        $this->actingAs($this->admin)
            ->post(action('ApproveController@ok', [
                'recipe' => $this->unapproved_recipe->id,
            ]))
            ->assertRedirect("/recipes/{$this->unapproved_recipe->id}");

        // Recipe should be still unapproved
        $this->assertDatabaseHas('recipes', [
            'id' => $this->unapproved_recipe->id,
            'approved_' . lang() => 0,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function admin_can_cancel_recipe_with_message(): void
    {
        $this->actingAs($this->admin)
            ->get("/recipes/{$this->unapproved_recipe->id}");

        // Make request to cancel a recipe with message
        $this->actingAs($this->admin)
            ->post(action('ApproveController@cancel',
                ['recipe' => $this->unapproved_recipe->id]),
                ['message' => 'Lorem ipsum dolor sit amet consectetur'])
            ->assertRedirect('/recipes');

        // Recipe should be still unapproved
        $this->assertDatabaseHas('recipes', [
            'id' => $this->unapproved_recipe->id,
            'approved_' . lang() => 0,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function admin_cant_cancel_recipe_without_message(): void
    {
        $this->actingAs($this->admin)
            ->get("/recipes/{$this->unapproved_recipe->id}");

        // Make request to cancel a recipe with message
        $this->actingAs($this->admin)
            ->post(action('ApproveController@cancel', ['recipe' => $this->unapproved_recipe->id]))
            ->assertRedirect("/recipes/{$this->unapproved_recipe->id}");

        // Recipe should be still unapproved
        $this->assertDatabaseHas('recipes', [
            'id' => $this->unapproved_recipe->id,
            'approved_' . lang() => 0,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function user_gets_notified_when_approved_his_recipe(): void
    {
        $user = create(User::class);
        $recipe = create(Recipe::class, [
            'user_id' => $user->id,
            'approved_' . lang() => 0,
        ]);
        $text_message = 'Lorem ipsum dolor sit amet consectetur han';

        $this->actingAs($this->admin)
            ->get("/recipes/$recipe->id");

        // Make request to approve a recipe with message
        $this->actingAs($this->admin)
            ->post(action('ApproveController@ok',
                ['recipe' => $recipe->id]),
                ['message' => $text_message])
            ->assertRedirect('/recipes');

        // Now from user side
        $this->actingAs($user)
            ->get('/notifications')
            ->assertSeeText($text_message);
    }
}
