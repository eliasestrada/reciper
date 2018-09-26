<?php

namespace Tests\Unit\Models;

use App\Models\Document;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Document::class);
    }

    /** @test */
    public function get_title_method_returns_title(): void
    {
        $document = make(Document::class, ['title_' . lang() => 'Название документа']);
        $this->assertEquals('Название документа', $document->getTitle());
    }

    /** @test */
    public function get_text_method_returns_text(): void
    {
        $document = make(Document::class, ['text_' . lang() => 'Название документа']);
        $this->assertEquals('Название документа', $document->getText());
    }

    /** @test */
    public function is_ready_method_returns_true_when_doc_is_ready(): void
    {
        $document = make(Document::class, ['ready_' . lang() => 1]);
        $this->assertTrue($document->isReady());
    }
}
