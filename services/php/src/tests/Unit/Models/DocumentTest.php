<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Document;

class DocumentTest extends TestCase
{
    /**
     * @test
     */
    public function document_model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Document::class);
    }

    /**
     * @test
     */
    public function getTitle_method_returns_title_column(): void
    {
        $document = make(Document::class, [_('title') => 'Название документа']);
        $this->assertEquals('Название документа', $document->getTitle());
    }

    /**
     * @test
     */
    public function getText_method_returns_text_column(): void
    {
        $document = make(Document::class, [_('text') => 'Название']);
        $this->assertEquals('Название', $document->getText());
    }

    /**
     * @test
     */
    public function isReady_method_returns_true_when_column_ready_is_set_to_1(): void
    {
        $document = make(Document::class, [_('ready') => 1]);
        $this->assertTrue($document->isReady());
    }
}
