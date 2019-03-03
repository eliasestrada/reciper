<?php

namespace App\Http\Controllers\Admin;

use App\Models\Recipe;
use App\Http\Controllers\Controller;
use App\Http\Requests\DisapproveRequest;
use App\Http\Responses\Controllers\Admin\Approves\ShowResponse;
use App\Http\Responses\Controllers\Admin\Approves\IndexResponse;
use App\Http\Responses\Controllers\Admin\Approves\ApproveResponse;
use App\Http\Responses\Controllers\Admin\Approves\DisapproveResponse;

class ApproveController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Shows all recipes that need to be approved
     * by administration
     *
     * @return \App\Http\Responses\Controllers\Admin\Approves\IndexResponse
     */
    public function index(): IndexResponse
    {
        return new IndexResponse;
    }

    /**
     * Show single recipe
     *
     * @param string $slug
     * @return \App\Http\Responses\Controllers\Admin\Approves\ShowResponse
     */
    public function show(string $slug): ShowResponse
    {
        $recipe = Recipe::whereSlug($slug)->first();
        return new ShowResponse($recipe);
    }

    /**
     * Approve given recipe
     * Dispaches event \App\Events\RecipeGotApproved
     *
     * @param string $slug
     * @return \App\Http\Responses\Controllers\Admin\Approves\ApproveResponse
     */
    public function approve(string $slug): ApproveResponse
    {
        $recipe = Recipe::whereSlug($slug)->first();
        return new ApproveResponse($recipe);
    }

    /**
     * Disapprove given recipe
     * Dispaches event \App\Events\RecipeGotCanceled
     *
     * @param string $slug
     * @param \App\Http\Requests\DisapproveRequest $request
     * @return \App\Http\Responses\Controllers\Admin\Approves\ApproveResponse
     */
    public function disapprove(string $slug, DisapproveRequest $request): DisapproveResponse
    {
        $recipe = Recipe::whereSlug($slug)->first();
        return new DisapproveResponse($recipe);
    }
}
