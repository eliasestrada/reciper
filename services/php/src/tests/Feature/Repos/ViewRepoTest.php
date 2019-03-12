<?php

namespace Tests\Feature\Repos;

use Tests\TestCase;
use App\Models\View;
use App\Models\Visitor;
use App\Repos\ViewRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\ViewRepo
     */
    private $repo;

    /**
     * Setup the test environment
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repo = new ViewRepo;
    }

    /**
     * @test
     */
    public function method_getViewedRecipeIds_returns_recipe_ids(): void
    {
        $recipe_id = 1;
        $visitor_id = create(Visitor::class)->id;
        $view = create(View::class, compact('visitor_id', 'recipe_id'));

        $result = $this->repo->getViewedRecipeIds($visitor_id);

        $this->assertEquals($recipe_id, $result[0]);
    }
}
