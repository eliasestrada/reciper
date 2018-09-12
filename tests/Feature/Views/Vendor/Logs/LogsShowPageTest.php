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
    public function view_vendor_logs_show_has_correct_path(): void
    {
        $file_name = $this->createLogFile();

        $this->actingAs($this->master)
            ->get("/log-viewer/logs/$file_name/info")
            ->assertViewIs('log-viewer::custom-theme.show')
            ->assertOk();
    }

    /** @test */
    public function master_can_see_logs_shows_page(): void
    {
        $file_name = $this->createLogFile();

        $this->actingAs($this->master)
            ->get("/log-viewer/logs/$file_name/info")
            ->assertSeeText($file_name);
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
