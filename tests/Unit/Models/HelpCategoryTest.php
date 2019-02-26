<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Help;
use App\Models\HelpCategory;

class HelpCategoryTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function help_category_model_has_attributes(): void
    {
        array_map(function ($attr) {
            $this->assertClassHasAttribute($attr, Help::class);
        }, ['table', 'guarded', 'timestamps']);
    }

    /**
     * @author Cho
     * @test
     */
    public function getTitle_method_returns_title_from_database_column(): void
    {
        $help = make(HelpCategory::class);
        $this->assertEquals($help->getTitle(), $help->toArray()[_('title')]);
    }
}
