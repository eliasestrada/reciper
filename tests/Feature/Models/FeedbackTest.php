<?php

namespace Tests\Feature\Models;

use App\Models\Feedback;
use App\Models\Recipe;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Feedback::class);
        $this->assertClassHasAttribute('timestamps', Feedback::class);
    }

    /** @test */
    public function model_has_relationship_with_recipe(): void
    {
        $recipe = create(Recipe::class);
        $feedback = Feedback::create([
            'recipe_id' => $recipe->id,
            'visitor_id' => create(Visitor::class)->id,
            'lang' => lang(),
            'message' => 'Lorem ipsum dolor sit amet, consectetur adipisicing',
        ]);

        $this->assertEquals($recipe->getTitle(), $feedback->recipe->getTitle());
    }

    /** @test */
    public function model_has_relationship_with_visitor(): void
    {
        $visitor = create(Visitor::class);
        $feedback = Feedback::create([
            'visitor_id' => $visitor->id,
            'lang' => lang(),
            'message' => 'Lorem ipsum dolor sit amet, consectetur adipisicing',
        ]);

        $this->assertEquals($visitor->id, $feedback->visitor->id);
    }
}
