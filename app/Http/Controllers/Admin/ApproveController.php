<?php
namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Models\Recipe;
use App\Http\Controllers\Controller;
use App\Http\Requests\DisapproveRequest;
use App\Http\Responses\Controllers\Admin\Approves\ShowResponse;
use App\Http\Responses\Controllers\Admin\Approves\IndexResponse;
use App\Http\Responses\Controllers\Admin\Approves\ApproveResponse;
use App\Http\Responses\Controllers\Admin\Approves\DisapproveResponse;
use App\Repos\RecipeRepo;

class ApproveController extends Controller
{
    /**
     * @var \App\Repos\RecipeRepo
     */
    private $recipe_repo;

    /**
     * @param \App\Repos\RecipeRepo $recipe_repo
     * @return void
     */
    public function __construct(RecipeRepo $recipe_repo)
    {
        $this->middleware('admin');
        $this->recipe_repo = $recipe_repo;
    }

    /**
     * Shows all recipes that need to be approved
     * by administration
     *
     * @return \App\Http\Responses\Controllers\Admin\Approves\IndexResponse
     */
    public function index(): IndexResponse
    {
        return new IndexResponse($this->recipe_repo);
    }

    /**
     * Show single recipe
     *
     * @param string $slug
     * @return \App\Http\Responses\Controllers\Admin\Approves\ShowResponse
     */
    public function show(string $slug): ShowResponse
    {
        return new ShowResponse($this->recipe_repo->find($slug));
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
        return new ApproveResponse($this->recipe_repo->find($slug));
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
        return new DisapproveResponse($this->recipe_repo->find($slug));
    }
}
