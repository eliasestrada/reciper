<?php

namespace Tests\Feature\Repos;

use Tests\TestCase;
use App\Models\Document;
use App\Repos\DocumentRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DocumentRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Repos\DocumentRepo $repo
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
        $this->repo = new DocumentRepo;
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

    /**
     * @author Cho
     * @test
     */
    public function paginateWithReadyStatus_method_returns_all_records_from_db(): void
    {
        create(Document::class, [], 2, 'draft');

        $ready_docs = $this->repo->paginateWithReadyStatus(1);
        $not_ready_docs = $this->repo->paginateWithReadyStatus(0);

        $this->assertCount(1, $ready_docs);
        $this->assertCount(2, $not_ready_docs);
    }
}
