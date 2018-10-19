<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Category::class);
        $this->assertClassHasAttribute('timestamps', Category::class);
    }

    /** @test */
    public function getName_method_returns_name_column(): void
    {
        $category = Category::make(['name_' . lang() => 'Some name']);
        $this->assertEquals($category->getName(), 'Some name');
    }
}
