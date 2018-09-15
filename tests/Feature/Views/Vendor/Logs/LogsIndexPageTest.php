<?php

namespace Tests\Feature\Views\Vendor\Logs;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LogsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    private $master;

    public function setUp(): void
    {
        parent::setUp();

        $this->master = create_user('master');
    }

    /** @test */
    public function view_has_a_correct_path(): void
    {
        $this->actingAs($this->master)
            ->get('/log-viewer/logs')
            ->assertViewIs('log-viewer::custom-theme.logs')
            ->assertOk();
    }

    /** @test */
    public function master_can_see_the_page(): void
    {
        $this->actingAs($this->master)
            ->get('/log-viewer/logs')
            ->assertOk()
            ->assertSeeText(trans('logs.logs'))
            ->assertDontSeeText(trans('logs.page_is_not_avail'));
    }

    /** @test */
    public function master_can_delete_log_file(): void
    {
        $file_name = $this->createLogFile();

        $this->assertFileExists(storage_path("logs/laravel-{$file_name}.log"));

        // Delete file
        $this->actingAs($this->master)
            ->followingRedirects()
            ->delete(action('Master\LogsController@delete'), [
                'date' => $file_name,
            ])
            ->assertSeeText(trans('logs.deleted'));

        $this->assertFileNotExists(storage_path("logs/laravel-{$file_name}.log"));
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
