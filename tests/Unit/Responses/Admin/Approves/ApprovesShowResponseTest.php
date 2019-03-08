<?php

namespace Tests\Unit\Repos\Admin;

use Tests\TestCase;
use App\Models\Recipe;
use Illuminate\View\View;
use App\Http\Responses\Controllers\Admin\Approves\ShowResponse;

class ApprovesShowResponseTest extends TestCase
{
    /**
     * @test
     */
    public function method_toResponse_redirects_with_status_302_if_recipe_is_already_approved(): void
    {
        $recipe = make(Recipe::class);
        $response = (new ShowResponse($recipe))->toResponse(null);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function method_toResponse_redirects_if_recipe_is_in_frafts(): void
    {
        $recipe = make(Recipe::class, [], null, 'draft');
        $response = (new ShowResponse($recipe))->toResponse(null);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function method_toResponse_returns_view_if_recipe_is_ready_and_not_approved(): void
    {
        $recipe = make(Recipe::class, [_('approved') => 0]);
        $response = (new ShowResponse($recipe))->toResponse(null);
        $this->assertInstanceOf(View::class, $response);
    }
}
