<?php

namespace Tests\Feature\Repos;

use App\Http\Requests\HelpRequest;
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
        $this->assertArrayHasKey('title_' . LANG(), $result[0]);
        $this->assertArrayHasKey('help_category_id', $result[0]);
    }

    /**
     * @author Cho
     * @test
     */
    public function update_method_updates_given_record_in_db(): void
    {
        $help = create(Help::class, ['title_' . LANG() => 'Test']);
        $data = [
            'title' => str_random(12),
            'text' => str_random(20),
            'category' => 1,
        ];

        HelpRepo::update($help, new HelpRequest($data));

        $this->assertEquals($data['title'], $help->getTitle());
    }

    /**
     * @author Cho
     * @test
     */
    public function create_method_creates_record_in_db(): void
    {
        $data = [
            'title' => str_random(12),
            'text' => str_random(20),
            'category' => 1,
        ];

        HelpRepo::create(new HelpRequest($data));

        $help_exists = Help::where('title_' . LANG(), $data['title'])->exists();
        $this->assertTrue($help_exists);
    }
}
