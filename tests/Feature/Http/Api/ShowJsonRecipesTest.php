<?php

namespace Tests\Feature\Http\Api;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ShowJsonRecipesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Try to see json api/recipes
     * We expect 3 json: data, links, meta
     * @test
     */
    public function see_recipes_json(): void
    {
        create(Recipe::class, [
            'intro_' . lang() => 'Hello world',
        ]);

        $this->json('GET', '/api/recipes')
            ->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonFragment(['intro' => 'Hello world']);
    }

    /**
     * Try to see json api/recipes/other/random
     * @test
     */
    public function see_random_recipes_json(): void
    {
        create(Recipe::class, [
            'title_' . lang() => 'Test 1',
        ]);

        $this->json('GET', "/api/recipes-random/1")
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonFragment(['title' => 'Test 1']);
    }

    /**
     * Try to see json api/recipes/other/categories
     * @test
     */
    public function see_categories_json(): void
    {
        app()->setLocale('ru');

        $this->get('/api/recipes-category')
            ->assertJsonFragment(['id' => 2, 'name_ru' => 'Выпечка']);

        app()->setLocale('en');
        $this->get('/api/recipes-category')
            ->assertJsonFragment(['id' => 2, 'name_en' => 'Bakery']);
    }
}
