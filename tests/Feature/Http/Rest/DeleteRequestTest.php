<?php

namespace Tests\Feature\Http\Rest;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeleteRequestTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     * @test
     */
    public function deleteRecipeRequest(): void
    {
        $recipe = factory(Recipe::class)->create();
        $this->assertDatabaseHas('recipes', $recipe->toArray());

        $response = $this->delete("/api/recipes/$recipe->id");
        $response->assertStatus(200);

        $this->assertEquals('success', $response->original);
    }
}
