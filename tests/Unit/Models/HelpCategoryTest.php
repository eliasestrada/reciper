<?php

namespace Tests\Unit\Models;

use App\Models\Help;
use App\Models\HelpCategory;
use Tests\TestCase;

class HelpCategoryTest extends TestCase
{
    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('table', Help::class);
        $this->assertClassHasAttribute('guarded', Help::class);
        $this->assertClassHasAttribute('timestamps', Help::class);
    }

    /** @test */
    public function getTitle_method_returns_title_from_database_column(): void
    {
        $help_category = make(HelpCategory::class);
        $this->assertEquals($help_category->getTitle(), $help_category->toArray()['title_' . LANG]);
    }
}
