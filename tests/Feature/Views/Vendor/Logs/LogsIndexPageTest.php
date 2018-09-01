<?php

namespace Tests\Feature\Views\Vendor\Logs;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LogsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    private $master;

    public function setUp(): void
    {
        parent::setUp();

        $this->master = make(User::class, ['master' => 1]);
    }

    /**
     * @test
     * @return void
     */
    public function view_vendor_logs_index_has_correct_path(): void
    {
        $this->actingAs($this->master)
            ->get('/log-viewer/logs')
            ->assertViewIs('log-viewer::custom-theme.logs')
            ->assertOk();
    }

    /**
     * @test
     * @return void
     */
    public function master_can_see_logs_page(): void
    {
        $this->actingAs($this->master)
            ->get('/log-viewer/logs')
            ->assertOk()
            ->assertSeeText(trans('logs.logs'))
            ->assertDontSeeText(trans('logs.page_is_not_avail'));
    }

    /**
     * @test
     * @return void
     */
    public function master_can_delete_log_file(): void
    {
        $file_name = $this->createLogFile();

        $this->assertFileExists(storage_path("logs/laravel-{$file_name}.log"));

        // Navigate to logs
        $this->actingAs($this->master)
            ->get('/log-viewer/logs');

        // Delete file
        $this->actingAs($this->master)
            ->followingRedirects()
            ->delete(action('LogsController@delete'), [
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
