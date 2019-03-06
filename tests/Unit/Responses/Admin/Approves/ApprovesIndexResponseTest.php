<?php

namespace Tests\Unit\Repos\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use App\Http\Responses\Controllers\Admin\Approves\IndexResponse;

class ApprovesIndesResponseTest extends TestCase
{
    /**
     * Function helper
     *
     * @param \App\Models\Recipe $recipe
     * @return \App\Http\Responses\Controllers\Approves\IndexResponse
     */
    // private function classReponse(Recipe $recipe, User $user): IndexResponse
    // {
    //     /** @var \App\Models\User $user */
    //     $user_mock = Mockery::mock(User::class);
    //     $user_mock->shouldReceive('id')->once();
    //     $user_mock->method('find')->willReturn($recipe);

    //     /** @var \App\Repos\RecipeRepo $recipe_mock */
    //     $recipe_mock = $this->createMock(RecipeRepo::class);
    //     $recipe_mock->method('find')->willReturn($recipe);

    //     return new IndexResponse($recipe_mock, $user_mock);
    // }

    /**
     * @author Cho
     * @test
     */
    public function method_toResponse_redirects_with_status_302_if_recipe(): void
    {
        $this->markTestIncomplete();
        // $recipe = make(Recipe::class, [_('approved') => 0]);
        // $user = make(User::class);
        // $response = $this->classReponse($recipe, $user)->toResponse(null);

        // $this->assertEquals(302, $response->getStatusCode());
    }
}
