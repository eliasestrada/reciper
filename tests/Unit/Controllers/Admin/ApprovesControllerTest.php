<?php

namespace Tests\Unit\Controllers\Admin;

use Tests\TestCase;
use App\Models\Recipe;
use App\Http\Requests\DisapproveRequest;
use App\Http\Controllers\Admin\ApproveController;

class ApproveControllerTest extends TestCase
{
    private $controller;

    /**
     * @author Cho
     */
    public function setUp()
    {
        parent::setUp();
        $this->controller = new ApproveController;
        $this->withoutEvents();
        $this->withoutNotifications();
    }

    /**
     * @author Cho
     * @test
     */
    public function show_method_redirects_with_status_302_if_recipe_is_already_approved(): void
    {
        $recipe = make(Recipe::class);
        $response = $this->controller->show($recipe)->toResponse(null);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * @author Cho
     * @test
     */
    public function show_method_redirects_if_recipe_is_in_frafts(): void
    {
        $recipe = make(Recipe::class, [], null, 'draft');
        $response = $this->controller->show($recipe)->toResponse(null);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * @author Cho
     * @test
     */
    public function show_method_returns_view_if_recipe_is_ready_and_not_approved(): void
    {
        $recipe = make(Recipe::class, [_('approved') => 0]);
        $response = $this->controller->show($recipe)->toResponse(null);
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    /**
     * @author Cho
     * @test
     */
    public function approve_method_redirects_with_error_if_recipe_is_already_approved(): void
    {
        $recipe = make(Recipe::class);
        $response = $this->controller->approve($recipe)->toResponse(null);
        $this->assertArrayNotHasKey('x-recipe-approved', $response->headers->all());
    }

    /**
     * @author Cho
     * @test
     */
    public function approve_method_redirects_without_success_header_if_recipe_is_in_frafts(): void
    {
        $recipe = make(Recipe::class, [], null, 'draft');
        $response = $this->controller->approve($recipe)->toResponse(null);
        $this->assertArrayNotHasKey('x-recipe-approved', $response->headers->all());
    }

    /**
     * @author Cho
     * @test
     */
    public function approve_method_redirects_with_success_header_if_recipe_is_ready_and_not_approved(): void
    {
        $recipe = make(Recipe::class, [_('approved') => 0]);
        $response = $this->controller->approve($recipe)->toResponse(null);
        $this->assertArrayHasKey('x-recipe-approved', $response->headers->all());
    }

    /**
     * @author Cho
     * @test
     */
    public function disapprove_method_redirects_without_success_header_if_recipe_is_already_approved(): void
    {
        $recipe = make(Recipe::class);
        $request = new DisapproveRequest(['message' => str_random(30)]);
        $response = $this->controller->disapprove($recipe, $request)->toResponse($request);
        $this->assertArrayNotHasKey('x-recipe-approved', $response->headers->all());
    }

    /**
     * @author Cho
     * @test
     */
    public function disapprove_method_redirects_without_success_header_if_recipe_is_in_drafts(): void
    {
        $recipe = make(Recipe::class, [], null, 'draft');
        $request = new DisapproveRequest(['message' => str_random(30)]);
        $response = $this->controller->disapprove($recipe, $request)->toResponse($request);
        $this->assertArrayNotHasKey('x-recipe-approved', $response->headers->all());
    }

    /**
     * @author Cho
     * @test
     */
    public function diapprove_method_redirects_with_success_header_if_recipe_is_ready_and_not_approved(): void
    {
        $recipe = make(Recipe::class, [_('approved') => 0]);
        $request = new DisapproveRequest(['message' => str_random(30)]);
        $response = $this->controller->disapprove($recipe, $request)->toResponse($request);
        $this->assertArrayHasKey('x-recipe-disapproved', $response->headers->all());
    }
}
