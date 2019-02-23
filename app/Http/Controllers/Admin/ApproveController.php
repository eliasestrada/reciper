<?php

namespace App\Http\Controllers\Admin;

use App\Models\Recipe;
use App\Http\Responses\Controllers\Admin\Approves\ShowResponse;
use App\Http\Responses\Controllers\Admin\Approves\IndexResponse;
use App\Http\Responses\Controllers\Admin\Approves\DisapproveResponse;
use App\Http\Responses\Controllers\Admin\Approves\ApproveResponse;
use App\Http\Requests\DisapproveRequest;
use App\Http\Controllers\Controller;

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
     * @param \App\Models\Recipe $recipe
     * @return \App\Http\Responses\Controllers\Admin\Approves\ShowResponse
     */
    public function show(Recipe $recipe): ShowResponse
    {
        return new ShowResponse($recipe);
    }

    /**
     * Approve given recipe
     * Dispaches event \App\Events\RecipeGotApproved
     *
     * @param \App\Models\Recipe $recipe
     * @return \App\Http\Responses\Controllers\Admin\Approves\ApproveResponse
     */
    public function approve(Recipe $recipe): ApproveResponse
    {
        return new ApproveResponse($recipe);
    }

    /**
     * Disapprove given recipe
     * Dispaches event \App\Events\RecipeGotCanceled
     *
     * @param \App\Models\Recipe $recipe
     * @param \App\Http\Requests\DisapproveRequest $request
     * @return \App\Http\Responses\Controllers\Admin\Approves\ApproveResponse
     */
    public function disapprove(Recipe $recipe, DisapproveRequest $request): DisapproveResponse
    {
        return new DisapproveResponse($recipe);
    }
}
