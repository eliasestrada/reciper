<?php

namespace Tests\Unit\Repos\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Repos\RecipeRepo;
use Illuminate\View\View;
use App\Http\Responses\Controllers\Admin\Approves\IndexResponse;

class ApprovesIndesResponseTest extends TestCase
{
    /**
     * @test
     */
    public function method_toResponse_redirects_if_getRecipeSlugThatAdminIsChecking_finds_recipe_slug(): void
    {
        /** @var \App\Repos\RecipeRepo $recipe_repo */
        $recipe_repo = $this->createMock(RecipeRepo::class);
        $recipe_repo->method('getRecipeSlugThatAdminIsChecking')->willReturn(string_random(7));
        $response_class = new IndexResponse($recipe_repo, User::make());

        $response = $response_class->toResponse(null);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function method_toResponse_returns_view_if_getRecipeSlugThatAdminIsChecking_returns_null(): void
    {
        /** @var \App\Repos\RecipeRepo $recipe_repo */
        $recipe_repo = $this->createMock(RecipeRepo::class);
        $recipe_repo->method('getRecipeSlugThatAdminIsChecking')->willReturn(null);
        $response_class = new IndexResponse($recipe_repo, User::make());

        $response = $response_class->toResponse(null);
        $this->assertInstanceOf(View::class, $response);
    }

    /**
     * @test
     */
    public function method_getRecipesArray_returns_array_with_3_arrays(): void
    {
        /** @var \App\Repos\RecipeRepo $recipe_repo */
        $recipe_repo = $this->createMock(RecipeRepo::class);
        $response_class = new IndexResponse($recipe_repo, User::make());
        $response = $response_class->getRecipesArray();

        array_walk($response, function ($single_arr) {
            $this->assertArrayHasKey('name', $single_arr);
            $this->assertArrayHasKey('recipes', $single_arr);
        });
    }
}
