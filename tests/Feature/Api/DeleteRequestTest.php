<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Recipe;

class DeleteRequestTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function recipe_deletes_after_delete_request(): void
    {
        $recipe = create(Recipe::class);
        $response = $this->delete("/api/recipes/$recipe->id");
        $response->assertStatus(200);
        $this->assertEquals('success', $response->original);
    }
}
