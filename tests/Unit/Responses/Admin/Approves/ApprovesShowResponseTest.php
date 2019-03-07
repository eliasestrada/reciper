<?php

namespace Tests\Unit\Repos\Admin;

use Tests\TestCase;
use App\Models\Recipe;
use App\Repos\RecipeRepo;
use Illuminate\View\View;
use App\Http\Responses\Controllers\Admin\Approves\ShowResponse;

class ApprovesShowResponseTest extends TestCase
{
    /**
     * Function helper
     *
     * @param \App\Models\Recipe $recipe
     * @return \App\Http\Responses\Controllers\Approves\ShowResponse
     */
    private function classReponse(Recipe $recipe): ShowResponse
    {
        /** @var \App\Repos\RecipeRepo $recipe_mock */
        $recipe_mock = $this->createMock(RecipeRepo::class);
        $recipe_mock->method('find')->willReturn($recipe);

        return new ShowResponse('some-slug', $recipe_mock);
    }

    /**
     * @test
     */
    public function method_toResponse_redirects_with_status_302_if_recipe_is_already_approved(): void
    {
        $recipe = make(Recipe::class);
        $response = $this->classReponse($recipe)->toResponse(null);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function method_toResponse_redirects_if_recipe_is_in_frafts(): void
    {
        $recipe = make(Recipe::class, [], null, 'draft');
        $response = $this->classReponse($recipe)->toResponse(null);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function method_toResponse_returns_view_if_recipe_is_ready_and_not_approved(): void
    {
        $recipe = make(Recipe::class, [_('approved') => 0]);
        $response = $this->classReponse($recipe)->toResponse(null);
        $this->assertInstanceOf(View::class, $response);
    }
}
