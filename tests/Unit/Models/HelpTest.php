<?php

namespace Tests\Unit\Models;

use App\Models\Help;
use Tests\TestCase;

class HelpTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function help_model_has_attributes(): void
    {
        array_map(function ($attr) {
            $this->assertClassHasAttribute($attr, Help::class);
        }, ['table', 'guarded', 'timestamps', 'dates']);
    }

    /**
     * @author Cho
     * @test
     */
    public function getTitle_method_returns_title_from_database_column(): void
    {
        $help = make(Help::class);
        $this->assertEquals($help->getTitle(), $help->toArray()['title_' . LANG()]);
    }

    /**
     * @author Cho
     * @test
     */
    public function getText_method_returns_text_from_database_column(): void
    {
        $help = make(Help::class);
        $this->assertEquals($help->getText(), $help->toArray()['text_' . LANG()]);
    }

    /**
     * @author Cho
     * @test
     */
    public function selectBasic_scope_method_returns_Id_Title_and_HelpCategoryId(): void
    {
        $help = Help::selectBasic()->first()->toArray();

        array_map(function ($key) use ($help) {
            $this->assertArrayHasKey($key, $help);
        }, ['id', 'title', 'help_category_id']);
    }
}
