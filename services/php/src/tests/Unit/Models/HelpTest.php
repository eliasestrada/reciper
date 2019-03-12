<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Help;

class HelpTest extends TestCase
{
    /**
     * @test
     */
    public function help_model_has_attributes(): void
    {
        array_map(function ($attr) {
            $this->assertClassHasAttribute($attr, Help::class);
        }, ['table', 'guarded', 'timestamps', 'dates']);
    }

    /**
     * @test
     */
    public function getTitle_method_returns_title_from_database_column(): void
    {
        $help = make(Help::class);
        $this->assertEquals($help->getTitle(), $help->toArray()[_('title')]);
    }

    /**
     * @test
     */
    public function getText_method_returns_text_from_database_column(): void
    {
        $help = make(Help::class);
        $this->assertEquals($help->getText(), $help->toArray()[_('text')]);
    }
}
