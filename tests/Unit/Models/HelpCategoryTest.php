<?php

namespace Tests\Unit\Models;

use App\Models\Help;
use App\Models\HelpCategory;
use Tests\TestCase;

class HelpCategoryTest extends TestCase
{
    public $help_category;

    public function setUp()
    {
        parent::setUp();
        $this->help_category = create(HelpCategory::class);
    }

    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('table', Help::class);
        $this->assertClassHasAttribute('guarded', Help::class);
        $this->assertClassHasAttribute('timestamps', Help::class);
    }

    /** @test */
    public function get_title_method_returns_title_from_database(): void
    {
        $this->assertEquals($this->help_category->getTitle(), $this->help_category->toArray()['title_' . lang()]);
    }

    /** @test */
    public function get_text_method_returns_text_from_database(): void
    {
        $this->assertEquals($this->help->getText(), $this->help->toArray()['text_' . lang()]);
    }
}
