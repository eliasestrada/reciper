<?php

namespace Tests\Feature\Views\Vendor\Logs;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LogsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/users/index
     * @test
     * @return void
     */
    public function view_users_index_has_data(): void
    {
        $master = factory(User::class)->make(['master' => 1]);

        $this->actingAs($master)
            ->get('/log-viewer/logs')
            ->assertViewIs('log-viewer::custom-theme.logs');
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
