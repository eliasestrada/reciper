<?php

namespace Tests\Unit\Models;

use App\Models\Recipe;
use App\Models\View;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ViewTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', View::class);
        $this->assertClassHasAttribute('timestamps', View::class);
    }

    /** @test */
    public function model_has_relationship_with_visitor(): void
    {
        $visitor = create(Visitor::class);
        $view = View::make([
            'visitor_id' => $visitor->id,
            'recipe_id' => make(Recipe::class)->id,
        ]);

        $this->assertEquals($visitor->id, $view->visitor->id);
    }

    /** @test */
    public function model_has_relationship_with_recipe(): void
    {
        $recipe = create(Recipe::class);
        $view = View::make([
            'visitor_id' => make(Visitor::class)->id,
            'recipe_id' => $recipe->id,
        ]);

        $this->assertEquals($recipe->id, $view->recipe->id);
    }
}
