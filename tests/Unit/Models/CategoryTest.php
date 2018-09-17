<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Category::class);
        $this->assertClassHasAttribute('timestamps', Category::class);
    }

    /** @test */
    public function model_has_relationship_with_recipes(): void
    {
        $recipe = create(Recipe::class);
        $recipe->categories()->sync(Category::find(1));

        $this->assertCount(1, $recipe->categories);
    }

    /** @test */
    public function get_name_method_returns_name_row(): void
    {
        $category = Category::make([
            'name_' . lang() => 'Some name',
        ]);

        $this->assertEquals($category->getName(), 'Some name');
    }
}
