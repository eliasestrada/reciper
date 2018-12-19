<?php

namespace Tests\Feature\Api;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ShowJsonRecipesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function see_latest_recipes_json_if_there_are_no_hash_in_url(): void
    {
        $recipe = create(Recipe::class);

        $this->json('GET', '/api/recipes')
            ->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonFragment(['intro' => $recipe->getIntro()]);
    }

    /**
     *  "1" in request url is visitor id
     * @author Cho
     * @test
     * */
    public function see_random_recipes_json(): void
    {
        $recipe = create(Recipe::class);

        $this->json('GET', "/api/recipes-random/1")
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonFragment(['title' => $recipe->getTitle()]);
    }
}
