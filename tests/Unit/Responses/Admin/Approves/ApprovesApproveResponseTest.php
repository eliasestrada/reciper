<?php

namespace Tests\Unit\Repos\Admin;

use Tests\TestCase;
use App\Models\Recipe;
use App\Repos\RecipeRepo;
use App\Http\Responses\Controllers\Admin\Approves\ApproveResponse;

class ApprovesApproveResponseTest extends TestCase
{
    /**
     * Function helper
     *
     * @param \App\Models\Recipe $recipe
     * @return \App\Http\Responses\Controllers\Approves\ApproveResponse
     */
    private function classReponse(Recipe $recipe): ApproveResponse
    {
        $this->withoutEvents();
        $this->withoutNotifications();

        /** @var \App\Repos\RecipeRepo $recipe_mock */
        $recipe_mock = $this->createMock(RecipeRepo::class);
        $recipe_mock->method('find')->willReturn($recipe);

        return new ApproveResponse('some-slug', $recipe_mock);
    }

    /**
     * @author Cho
     * @test
     */
    public function method_toResponse_redirects_with_error_if_recipe_is_already_approved(): void
    {
        $recipe = make(Recipe::class);
        $response = $this->classReponse($recipe)->toResponse(null);
        $this->assertArrayNotHasKey('x-recipe-approved', $response->headers->all());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_toResponse_redirects_without_success_header_if_recipe_is_in_frafts(): void
    {
        $recipe = make(Recipe::class, [], null, 'draft');
        $response = $this->classReponse($recipe)->toResponse(null);
        $this->assertArrayNotHasKey('x-recipe-approved', $response->headers->all());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_toResponse_redirects_with_success_header_if_recipe_is_ready_and_not_approved(): void
    {
        $recipe = make(Recipe::class, [_('approved') => 0]);
        $response = $this->classReponse($recipe)->toResponse(null);
        $this->assertArrayHasKey('x-recipe-approved', $response->headers->all());
    }
}
