<?php

namespace Tests\Feature\Requests\Recipes;

use Tests\TestCase;
use App\Models\User;

class RecipesStoreRequestTest extends TestCase
{
    /**
     * @var \App\Models\User $user
     */
    private $user;

    /**
     * Setup the test environment
     * 
     * @author Cho
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = make(User::class);
        $this->actingAs($this->user)->get('/users');
    }
    /**
     * @author Cho
     * @test
     */
    public function title_is_required(): void
    {
        $this->actingAs($this->user)
            ->post(action('RecipeController@store'), ['title' => ''])
            ->assertRedirect('/users');
    }

    /**
     * @author Cho
     * @test
     */
    public function title_must_be_not_short(): void
    {
        $this->actingAs($this->user)
            ->post(action('RecipeController@store'), [
                'title' => string_random(config('valid.recipes.title.min') - 1),
            ])
            ->assertRedirect('/users');
    }

    /**
     * @author Cho
     * @test
     */
    public function title_must_be_not_long(): void
    {
        $this->actingAs($this->user)
            ->post(action('RecipeController@store'), [
                'title' => string_random(config('valid.recipes.title.max') + 1),
            ])
            ->assertRedirect('/users');
    }
}
