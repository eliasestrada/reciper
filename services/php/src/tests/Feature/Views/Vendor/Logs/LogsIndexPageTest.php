<?php

namespace Tests\Feature\Views\Vendor\Logs;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LogsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \App\Models\User
     */
    private $master;

    /**
     * Setup the test environment
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->master = create_user('master');
    }

    /**
     * @test
     */
    public function master_can_see_the_page(): void
    {
        $this->actingAs($this->master)
            ->get('/log-viewer/logs')
            ->assertViewIs('log-viewer::custom-theme.logs')
            ->assertOk();
    }

    /**
     * Skip test for Windows machine to prevent causing error
     * 
     * @test
     * */
    public function master_can_delete_log_file(): void
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $this->assertTrue(true);
        } else {
            $file_name = $this->createLogFile();

            $this->assertFileExists(storage_path("logs/laravel-{$file_name}.log"));

            // Delete file
            $this->actingAs($this->master)
                ->delete(action('Master\LogController@destroy'), [
                    'date' => $file_name,
                ]);

            $this->assertFileNotExists(storage_path("logs/laravel-{$file_name}.log"));
        }
    }

    /**
     * Function helper
     * @return string
     */
    private function createLogFile(): string
    {
        info('test');
        return date('Y-m-d');
    }
}
