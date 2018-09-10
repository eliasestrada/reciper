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

        $this->admin = make(User::class, ['admin' => 1]);
        $this->recipe = make(Recipe::class);
        $this->unapproved_recipe = create(Recipe::class, [
            'approved_' . lang() => 0,
        ]);
    }

    /** @test */
    public function view_recipes_show_has_data(): void
    {
        $recipe = create(Recipe::class);

        $this->get("/recipes/$recipe->id")
            ->assertViewIs('recipes.show')
            ->assertViewHas('recipe');
    }

    /** @test */
    public function auth_user_can_see_recipe_show_page(): void
    {
        $user = make(User::class);
        $user2 = make(User::class);
        $recipe = make(Recipe::class, ['user_id' => $user->id]);
        $recipe2 = make(Recipe::class, ['user_id' => $user2->id]);

        $this->actingAs($user)->get("/recipes/$recipe->id")->assertOk();
        $this->actingAs($user2)->get("/recipes/$recipe->id")->assertOk();
    }

    /** @test */
    public function guest_can_see_recipes_show_page(): void
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

    /** @test */
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

    /** @test */
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

    /** @test */
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

    /** @test */
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

    /** @test */
    public function only_owner_of_the_recipe_can_see_action_buttons(): void
    {
        $owner = create(User::class);
        $recipe = create(Recipe::class, ['user_id' => $owner->id]);
        $link = "/recipes/{$recipe->id}";

        // Guest dont see buttons
        $this->get($link)
            ->assertDontSee('_action-buttons');

        // Authenticated user can't see buttons
        $this->actingAs(make(User::class))
            ->get($link)
            ->assertDontSee('_action-buttons');

        // Owner of the recipe can see action buttons
        $this->actingAs($owner)
            ->get($link)
            ->assertSee('_action-buttons');
    }
}
