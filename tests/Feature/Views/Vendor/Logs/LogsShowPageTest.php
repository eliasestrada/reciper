<?php

namespace Tests\Feature\Views\Vendor\Logs;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LogsShowPageTest extends TestCase
{
    use DatabaseTransactions;

    private $master;

    public function setUp(): void
    {
        parent::setUp();
        $this->master = create_user('master');
    }

    /** @test */
    public function master_can_see_the_page(): void
    {
        $file_name = $this->createLogFile();

        $this->actingAs($this->master)
            ->get("/log-viewer/logs/$file_name/info")
            ->assertViewIs('log-viewer::custom-theme.show')
            ->assertOk();
    }

    /**
     * @return string
     */
    private function createLogFile(): string
    {
        info('test');
        return date('Y-m-d');
    }
}
