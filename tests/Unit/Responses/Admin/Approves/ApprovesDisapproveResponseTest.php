<?php

namespace Tests\Unit\Repos\Admin;

use Tests\TestCase;
use App\Models\Recipe;
use App\Http\Requests\DisapproveRequest;
use App\Http\Responses\Controllers\Admin\Approves\DisapproveResponse;

class ApprovesDisapproveResponseTest extends TestCase
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
    public function method_toResponse_redirects_without_success_header_if_recipe_is_already_approved(): void
    {
        $request = new DisapproveRequest(['message' => string_random(30)]);
        $response_class = new DisapproveResponse(make(Recipe::class));
        $response = $response_class->toResponse($request);

        $this->assertArrayNotHasKey('x-recipe-approved', $response->headers->all());
    }

    /**
     * @test
     */
    public function method_toResponse_redirects_without_success_header_if_recipe_is_in_drafts(): void
    {
        $recipe = make(Recipe::class, [], null, 'draft');
        $request = new DisapproveRequest(['message' => string_random(30)]);
        $response_class = new DisapproveResponse($recipe);
        $response = $response_class->toResponse($request);

        $this->assertArrayNotHasKey('x-recipe-approved', $response->headers->all());
    }

    /**
     * @test
     */
    public function method_toResponse_redirects_with_success_header_if_recipe_is_ready_and_not_approved(): void
    {
        $recipe = make(Recipe::class, [_('approved') => 0]);
        $request = new DisapproveRequest(['message' => string_random(30)]);
        $response_class = new DisapproveResponse($recipe);
        $response = $response_class->toResponse($request);

        $this->assertArrayHasKey('x-recipe-disapproved', $response->headers->all());
    }
}
