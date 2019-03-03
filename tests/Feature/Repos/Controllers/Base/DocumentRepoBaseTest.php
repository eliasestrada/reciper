<?php

namespace Tests\Feature\Repos\Controllers\Base;

use Tests\TestCase;
use App\Models\Document;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repos\Controllers\Base\DocumentRepoBase;

class DocumentRepoBaseTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\Controllers\DocumentRepo $repo
     */
    private $repo;

    /**
     * Setup the test environment
     * 
     * @author Cho
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repo = new DocumentRepoBase;
    }

    /**
     * @author Cho
     * @test
     */
    public function method_find_returns_document_by_given_id(): void
    {
        $document = create(Document::class);
        $result = $this->repo->find($document->id);
        $this->assertEquals($document->toBase(), $result->toBase());
    }
}
