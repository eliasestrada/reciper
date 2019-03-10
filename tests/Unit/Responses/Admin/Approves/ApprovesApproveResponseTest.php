<?php

namespace Tests\Unit\Repos\Admin;

use Tests\TestCase;
use App\Models\Recipe;
use App\Http\Responses\Controllers\Admin\Approves\ApproveResponse;

class ApprovesApproveResponseTest extends TestCase
{
    /**
     * Setup the test environment
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutNotifications();
        $this->withoutEvents();
    }

    /**
     * @test
     */
    public function method_toResponse_redirects_with_error_if_recipe_is_already_approved(): void
    {
        $response_class = new ApproveResponse(make(Recipe::class));
        $response = $response_class->toResponse(null);
        $this->assertArrayNotHasKey('x-recipe-approved', $response->headers->all());
    }

    /**
     * @test
     */
    public function method_toResponse_redirects_without_success_header_if_recipe_is_in_frafts(): void
    {
        $recipe = make(Recipe::class, [], null, 'draft');
        $response_class = new ApproveResponse($recipe);
        $response = $response_class->toResponse(null);
        $this->assertArrayNotHasKey('x-recipe-approved', $response->headers->all());
    }

    /**
     * @test
     */
    public function method_toResponse_redirects_with_success_header_if_recipe_is_ready_and_not_approved(): void
    {
        $recipe = make(Recipe::class, [_('approved') => 0]);
        $response_class = new ApproveResponse($recipe);
        $response = $response_class->toResponse(null);
        $this->assertArrayHasKey('x-recipe-approved', $response->headers->all());
    }
}
