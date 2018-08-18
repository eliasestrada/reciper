<?php

namespace Tests\Unit\Models;

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

        $this->visitor = Visitor::create([
            'ip' => '122.12.12.12',
        ]);

        $this->like = Like::create([
            'visitor_id' => $this->visitor->id,
            'recipe_id' => $this->recipe->id,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Like::class);
        $this->assertClassHasAttribute('timestamps', Like::class);
    }

    /**
     * @test
     * @return void
     */
    public function model_has_relationship_with_visitor(): void
    {
        $this->assertTrue($this->like->visitor()->exists());
        $this->assertEquals(1, $this->like->visitor()->count());
    }

    /**
     * @test
     * @return void
     */
    public function model_has_relationship_with_recipes(): void
    {
        $this->assertTrue($this->like->recipe()->exists());
        $this->assertEquals(1, $this->like->recipe()->count());
    }
}
