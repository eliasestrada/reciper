<?php

namespace Tests\Feature\Views\Vendor\Logs;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LogsShowPageTest extends TestCase
{
    use DatabaseTransactions;

    private $master;

    /**
     * @author Cho
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->master = create_user('master');
    }

    /**
     * @author Cho
     * @test
     */
    public function master_can_see_the_page(): void
    {
        $file_name = $this->createLogFile();

        $this->actingAs($this->master)
            ->get("/log-viewer/logs/{$file_name}/info")
            ->assertViewIs('log-viewer::custom-theme.show')
            ->assertOk();

        \File::cleanDirectory(storage_path('logs'));
    }

    /**
     * Function helper
     * @author Cho
     * @return string
     */
    private function createLogFile(): string
    {
        info('test');
        return date('Y-m-d');
    }
}
