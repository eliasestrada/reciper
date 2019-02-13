<?php

namespace Tests\Feature\Requests\Recipes;

use App\Models\User;
use Tests\TestCase;

class RecipesStoreRequestTest extends TestCase
{
    private $user;

    /**
     * @author Cho
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
                'title' => str_random(config('valid.recipes.title.min') - 1),
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
                'title' => str_random(config('valid.recipes.title.max') + 1),
            ])
            ->assertRedirect('/users');
    }
}
