<?php

namespace Tests\Feature\Models;

use App\Models\Help;
use App\Models\HelpCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HelpCategoryTest extends TestCase
{
    use DatabaseTransactions;

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
}
