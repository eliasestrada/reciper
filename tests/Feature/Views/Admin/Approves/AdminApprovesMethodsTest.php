<?php

namespace Tests\Feature\View\Admin\Approves;

use App\Http\Controllers\Admin\ApprovesController;
use App\Models\Recipe;
use Tests\TestCase;

class AdminApprovesMethodsTest extends TestCase
{
    /** @test */
    public function approve_method_redirects_if_recipe_is_already_approved(): void
    {
        $this->withoutEvents();
        $response = (new ApprovesController)->approve(make(Recipe::class));

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertArrayHasKey('x-recipe-cant-be-approved', $response->headers->all());
    }
}
