<?php

namespace Tests\Unit\Models;

use App\Models\Document;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function method_get_title_return_title(): void
    {
        $document = factory(Document::class)->make([
            'title_' . locale() => 'Название документа',
        ]);

        $this->assertEquals('Название документа', $document->getTitle());
    }

    /**
     * @test
     * @return void
     */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Document::class);
    }
}
