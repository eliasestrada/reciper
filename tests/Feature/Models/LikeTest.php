<?php

namespace Tests\Feature\Models;

use App\Models\Like;
use App\Models\Recipe;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use DatabaseTransactions;

    private $visitor;
    private $recipe;
    private $like;

    public function setUp(): void
    {
        parent::setUp();

        $this->recipe = create(Recipe::class);
        $this->visitor = create(Visitor::class);
        $this->like = Like::create([
            'visitor_id' => $this->visitor->id,
            'recipe_id' => $this->recipe->id,
        ]);
    }

    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Like::class);
        $this->assertClassHasAttribute('timestamps', Like::class);
    }

    /** @test */
    public function model_has_relationship_with_visitor(): void
    {
        $this->assertTrue($this->like->visitor()->exists());
    }

    /** @test */
    public function model_has_relationship_with_recipe(): void
    {
        $this->assertTrue($this->like->recipe()->exists());
    }
}
