<?php

namespace Tests\Feature\Http\Rest;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ShowJsonRecipesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Try to see json api/recipes
     * We expect 3 json: data, links, meta
     * @return void
     * @test
     */
    public function see_recipes_json(): void
    {
        factory(Recipe::class)->create([
            'intro_' . lang() => 'Hello world',
        ]);

        $this->json('GET', '/api/recipes')
            ->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonFragment(['intro' => 'Hello world']);
    }

    /**
     * Try to see json api/recipes/other/random
     * @return void
     * @test
     */
    public function see_random_recipes_json(): void
    {
        $recipe1 = factory(Recipe::class)->create([
            'title_' . lang() => 'Test 1',
        ]);

        $recipe2 = factory(Recipe::class)->create([
            'title_' . lang() => 'Test 2',
        ]);

        $this->json('GET', "/api/recipes/other/random/$recipe1->id")
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonMissing(['title' => 'Test 1'])
            ->assertJsonFragment(['title' => 'Test 2']);
    }

    /**
     * Try to see json api/recipes/other/categories
     * @test
     * @return void
     */
    public function see_categories_json(): void
    {
        app()->setLocale('ru');
        $this->get('/api/recipes/other/categories')
            ->assertJsonFragment(['id' => 2, 'name_ru' => 'Выпечка']);

        app()->setLocale('en');
        $this->get('/api/recipes/other/categories')
            ->assertJsonFragment(['id' => 2, 'name_en' => 'Bakery']);
    }
}
