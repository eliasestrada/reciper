<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeleteRequestTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function recipe_deletes_after_delete_request(): void
    {
        $response = $this->delete('/api/recipes/1');
        $response->assertStatus(200);
        $this->assertEquals('success', $response->original);
    }
}
