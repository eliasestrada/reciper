<?php

namespace Tests\Feature\Views\Vendor\Logs;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LogsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test for logs page. View: resources/vendor/log-viewer/custom-theme/logs
     * @return void
     * @test
     */
    public function masterCanSeeLogsPage(): void
    {
        $master = User::find(factory(User::class)->create(['master' => 1])->id);

        $this->actingAs($master)
            ->get('/log-viewer/logs')
            ->assertSeeText(trans('logs.logs'))
            ->assertDontSeeText(trans('logs.page_is_not_avail'));
    }
}
