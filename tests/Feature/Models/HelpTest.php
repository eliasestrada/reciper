<?php

namespace Tests\Feature\Models;

use App\Models\Help;
use Tests\TestCase;

class HelpTest extends TestCase
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
        $help = make(Help::class);
        $this->assertEquals($help->getTitle(), $help->toArray()['title_' . lang()]);
    }

    /** @test */
    public function getText_method_returns_text_from_database_column(): void
    {
        $help = make(Help::class);
        $this->assertEquals($help->getText(), $help->toArray()['text_' . lang()]);
    }
}
