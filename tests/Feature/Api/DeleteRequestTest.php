<?php

namespace Tests\Feature\Api;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeleteRequestTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function delete_recipe_request(): void
    {
        $recipe = create(Recipe::class);
        $this->assertDatabaseHas('recipes', $recipe->toArray());

        $response = $this->delete("/api/recipes/$recipe->id");
        $response->assertStatus(200);

        $this->assertEquals('success', $response->original);
    }
}
