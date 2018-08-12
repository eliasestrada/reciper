<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function model_has_relationship_with_recipes(): void
    {
        $recipe = factory(Recipe::class)->create();
        $recipe->categories()->sync(Category::find(1));

        $this->assertTrue($recipe->categories()->exists());
        $this->assertCount(1, $recipe->categories);
    }

    /**
     * @test
     * @return void
     */
    public function method_get_name_returns_name(): void
    {
        $category = Category::make([
            'name_' . locale() => 'Some name',
        ]);

        $this->assertEquals($category->getName(), 'Some name');
    }

    /**
     * @test
     * @return void
     */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Category::class);
        $this->assertClassHasAttribute('timestamps', Category::class);
    }
}
