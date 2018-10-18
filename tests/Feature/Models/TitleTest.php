<?php

namespace Tests\Unit\Models;

use App\Models\Title;
use Tests\TestCase;

class TitleTest extends TestCase
{
    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('timestamps', Title::class);
        $this->assertClassHasAttribute('guarded', Title::class);
    }

    /** @test */
    public function get_title_method_returns_title_row(): void
    {
        $title = Title::make(['title_' . lang() => 'Somonilusas', 'name' => 'some']);
        $this->assertEquals('Somonilusas', $title->getTitle());
    }

    /** @test */
    public function get_text_method_returns_text_row(): void
    {
        $text = Title::make(['text_' . lang() => 'Honavora', 'name' => 'john']);
        $this->assertEquals('Honavora', $text->getText());
    }
}
