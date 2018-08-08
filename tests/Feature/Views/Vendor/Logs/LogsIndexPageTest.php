<?php

namespace Tests\Feature\Views\Vendor\Logs;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LogsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/vendor/log-viewer/custom-theme/logs
     * @test
     * @return void
     */
    public function view_vendor_logs_index_has_correct_path(): void
    {
        $master = factory(User::class)->make(['master' => 1]);

        $this->actingAs($master)
            ->get('/log-viewer/logs')
            ->assertViewIs('log-viewer::custom-theme.logs')
            ->assertOk();
    }

    /**
     * resources/vendor/log-viewer/custom-theme/logs
     * @test
     * @return void
     */
    public function master_can_see_logs_page(): void
    {
        $master = factory(User::class)->make(['master' => 1]);

        $this->actingAs($master)
            ->get('/log-viewer/logs')
            ->assertOk()
            ->assertSeeText(trans('logs.logs'))
            ->assertDontSeeText(trans('logs.page_is_not_avail'));
    }
}
