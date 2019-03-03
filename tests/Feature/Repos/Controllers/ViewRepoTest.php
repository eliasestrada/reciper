<?php

namespace Tests\Feature\Repos\Controllers;

use Tests\TestCase;
use App\Models\View;
use App\Models\Visitor;
use App\Repos\Controllers\ViewRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\Controllers\ViewRepo $repo
     */
    private $repo;

    /**
     * Setup the test environment
     * 
     * @author Cho
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repo = new ViewRepo;
    }

    /**
     * @author Cho
     * @test
     */
    public function method_pluckViewedRecipeIds_returns_recipe_ids(): void
    {
        $recipe_id = 1;
        $visitor_id = create(Visitor::class)->id;
        $view = create(View::class, compact('visitor_id', 'recipe_id'));

        $result = $this->repo->pluckViewedRecipeIds($visitor_id);

        $this->assertEquals($recipe_id, $result->first());
    }
}
