<?php

namespace Tests\Unit\Repos\Admin;

use Tests\TestCase;
use App\Models\Recipe;
use App\Repos\RecipeRepo;
use App\Http\Requests\DisapproveRequest;
use App\Http\Responses\Controllers\Admin\Approves\DisapproveResponse;

class ApprovesDisapproveResponseTest extends TestCase
{
    /**
     * Function helper
     *
     * @param \App\Models\Recipe $recipe
     * @return \App\Http\Responses\Controllers\Approves\DisapproveResponse
     */
    private function classReponse(Recipe $recipe): DisapproveResponse
    {
        $this->withoutEvents();
        $this->withoutNotifications();

        /** @var \App\Repos\RecipeRepo $recipe_mock */
        $recipe_mock = $this->createMock(RecipeRepo::class);
        $recipe_mock->method('find')->willReturn($recipe);

        return new DisapproveResponse('some-slug', $recipe_mock);
    }

    /**
     * @author Cho
     * @test
     */
    public function method_toResponse_redirects_without_success_header_if_recipe_is_already_approved(): void
    {
        $recipe = make(Recipe::class);
        $request = new DisapproveRequest(['message' => string_random(30)]);
        $response = $this->classReponse($recipe)->toResponse($request);

        $this->assertArrayNotHasKey('x-recipe-approved', $response->headers->all());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_toResponse_redirects_without_success_header_if_recipe_is_in_drafts(): void
    {
        $recipe = make(Recipe::class, [], null, 'draft');
        $request = new DisapproveRequest(['message' => string_random(30)]);
        $response = $this->classReponse($recipe)->toResponse($request);

        $this->assertArrayNotHasKey('x-recipe-approved', $response->headers->all());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_toResponse_redirects_with_success_header_if_recipe_is_ready_and_not_approved(): void
    {
        $recipe = make(Recipe::class, [_('approved') => 0]);
        $request = new DisapproveRequest(['message' => string_random(30)]);
        $response = $this->classReponse($recipe)->toResponse($request);

        $this->assertArrayHasKey('x-recipe-disapproved', $response->headers->all());
    }
}
