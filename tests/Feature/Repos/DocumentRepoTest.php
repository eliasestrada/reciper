<?php

namespace Tests\Feature\Repos;

use App\Models\Document;
use App\Repos\DocumentRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class DocumentRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function paginateAllWithReadyStatus_method_returns_pagination(): void
    {
        $result = DocumentRepo::paginateAllWithReadyStatus(1);
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    /**
     * @author Cho
     * @test
     */
    public function paginateAllWithReadyStatus_method_returns_all_records_from_db(): void
    {
        create(Document::class, [], 2, 'draft');

        $ready_docs = DocumentRepo::paginateAllWithReadyStatus(1);
        $not_ready_docs = DocumentRepo::paginateAllWithReadyStatus(0);

        $this->assertCount(1, $ready_docs);
        $this->assertCount(2, $not_ready_docs);
    }
}
