<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function category_model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Category::class);
        $this->assertClassHasAttribute('timestamps', Category::class);
    }

    /**
     * @author Cho
     * @test
     */
    public function category_model_has_relationships_with_recipe_model(): void
    {
        $this->assertNotNull(Category::first()->recipes);
    }

    /**
     * @author Cho
     * @test
     */
    public function getName_method_returns_name_column(): void
    {
        $category = Category::make([_('name') => 'Some name']);
        $this->assertEquals($category->getName(), 'Some name');
    }
}
