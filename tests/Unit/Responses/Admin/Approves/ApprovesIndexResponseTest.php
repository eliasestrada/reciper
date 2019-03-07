<?php

namespace Tests\Unit\Repos\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Repos\UserRepo;
use App\Repos\RecipeRepo;
use Illuminate\View\View;
use App\Http\Responses\Controllers\Admin\Approves\IndexResponse;

class ApprovesIndesResponseTest extends TestCase
{
    /**
     * Function helper
     *
     * @param \App\Repos\RecipeRepo $recipe_repo
     * @return \App\Http\Responses\Controllers\Approves\IndexResponse
     */
    private function classReponse(RecipeRepo $recipe_repo): IndexResponse
    {
        /** @var \App\Repos\UserRepo $user_repo */
        $user_repo = $this->createMock(UserRepo::class);
        $user_repo->method('find')->willReturn(make(User::class));

        return new IndexResponse($recipe_repo, $user_repo, 1);
    }

    /**
     * @author Cho
     * @test
     */
    public function method_toResponse_redirects_if_getRecipeSlugThatAdminIsChecking_finds_recipe_slug(): void
    {
        /** @var \App\Repos\RecipeRepo $recipe_repo */
        $recipe_repo = $this->createMock(RecipeRepo::class);
        $recipe_repo->method('getRecipeSlugThatAdminIsChecking')->willReturn(string_random(7));

        $response = $this->classReponse($recipe_repo)->toResponse(null);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * @author Cho
     * @test
     */
    public function method_toResponse_returns_view_if_getRecipeSlugThatAdminIsChecking_returns_null(): void
    {
        /** @var \App\Repos\RecipeRepo $recipe_repo */
        $recipe_repo = $this->createMock(RecipeRepo::class);
        $recipe_repo->method('getRecipeSlugThatAdminIsChecking')->willReturn(null);

        $response = $this->classReponse($recipe_repo)->toResponse(null);
        $this->assertInstanceOf(View::class, $response);
    }

    /**
     * @author Cho
     * @test
     */
    public function method_getRecipesArray_returns_array_with_3_arrays(): void
    {
        /** @var \App\Repos\RecipeRepo $recipe_repo */
        $recipe_repo = $this->createMock(RecipeRepo::class);
        $response = $this->classReponse($recipe_repo)->getRecipesArray();

        array_walk($response, function ($single_arr) {
            $this->assertArrayHasKey('name', $single_arr);
            $this->assertArrayHasKey('recipes', $single_arr);
        });
    }
}
