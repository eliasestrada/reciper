<?php

namespace Tests\Feature\Repos;

use App\Models\Help;
use App\Repos\HelpRepo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HelpRepoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function getCache_method_returns_all_help_records_from_db(): void
    {
        create(Help::class);
        $result = HelpRepo::getCache();

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey(_('title'), $result[0]);
        $this->assertArrayHasKey('help_category_id', $result[0]);
    }
}
