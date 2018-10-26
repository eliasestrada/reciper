<?php

namespace Tests\Unit\Controllers\Admin;

use App\Http\Controllers\Admin\ApprovesController;
use App\Http\Requests\DisapproveRequest;
use App\Models\Recipe;
use Tests\TestCase;

class ApprovesControllerTest extends TestCase
{
    /**
     * @author Cho
     */
    public function setUp()
    {
        parent::setUp();
        $this->withoutEvents();
    }

    /**
     * @author Cho
     * @test
     */
    public function approve_method_redirects_if_recipe_is_already_approved(): void
    {
        $recipe = make(Recipe::class);
        $response = (new ApprovesController)->approve($recipe);
        $this->assertArrayHasKey('x-recipe-cant-be-approved', $response->headers->all());
    }

    /**
     * @author Cho
     * @test
     */
    public function approve_method_redirects_if_recipe_is_in_frafts(): void
    {
        $recipe = make(Recipe::class, [], null, 'draft');
        $response = (new ApprovesController)->approve($recipe);
        $this->assertArrayHasKey('x-recipe-cant-be-approved', $response->headers->all());
    }

    /**
     * @author Cho
     * @test
     */
    public function approve_method_redirects_with_success_if_recipe_is_ready_and_not_approved(): void
    {
        $recipe = make(Recipe::class, ['approved_' . LANG() => 0]);
        $response = (new ApprovesController)->approve($recipe);
        $this->assertArrayHasKey('x-recipe-approved', $response->headers->all());
    }

    /**
     * @author Cho
     * @test
     */
    public function disapprove_method_redirects_if_recipe_is_already_approved(): void
    {
        $recipe = make(Recipe::class);
        $request = new DisapproveRequest(['message' => str_random(30)]);
        $response = (new ApprovesController)->disapprove($recipe, $request);
        $this->assertArrayHasKey('x-recipe-cant-be-approved', $response->headers->all());
    }

    /**
     * @author Cho
     * @test
     */
    public function disapprove_method_redirects_if_recipe_is_in_drafts(): void
    {
        $recipe = make(Recipe::class, [], null, 'draft');
        $request = new DisapproveRequest(['message' => str_random(30)]);
        $response = (new ApprovesController)->disapprove($recipe, $request);
        $this->assertArrayHasKey('x-recipe-cant-be-approved', $response->headers->all());
    }

    /**
     * @author Cho
     * @test
     */
    public function diapprove_method_redirects_with_success_if_recipe_is_ready_and_not_approved(): void
    {
        $recipe = make(Recipe::class, ['approved_' . LANG() => 0]);
        $request = new DisapproveRequest(['message' => str_random(30)]);
        $response = (new ApprovesController)->disapprove($recipe, $request);
        $this->assertArrayHasKey('x-recipe-disapproved', $response->headers->all());
    }
}
