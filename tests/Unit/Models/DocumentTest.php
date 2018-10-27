<?php

namespace Tests\Unit\Models;

use App\Models\Document;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function document_model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Document::class);
    }

    /**
     * @author Cho
     * @test
     */
    public function getTitle_method_returns_title_column(): void
    {
        $document = make(Document::class, ['title_' . LANG() => 'Название документа']);
        $this->assertEquals('Название документа', $document->getTitle());
    }

    /**
     * @author Cho
     * @test
     */
    public function getText_method_returns_text_column(): void
    {
        $document = make(Document::class, ['text_' . LANG() => 'Название']);
        $this->assertEquals('Название', $document->getText());
    }

    /**
     * @author Cho
     * @test
     */
    public function isReady_method_returns_true_when_column_ready_is_set_to_1(): void
    {
        $document = make(Document::class, ['ready_' . LANG() => 1]);
        $this->assertTrue($document->isReady());
    }

    /**
     * @author Cho
     * @test
     */
    public function selectBasic_scope_returns_only_id_title_and_text_columns(): void
    {
        $document = Document::selectBasic()->first()->toArray();

        array_map(function ($key) use ($document) {
            $this->assertArrayHasKey($key, $document);
        }, ['id', 'title', 'text']);
    }
}
