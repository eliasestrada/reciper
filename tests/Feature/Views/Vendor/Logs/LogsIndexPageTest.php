<?php

namespace Tests\Feature\Views\Vendor\Logs;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LogsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/vendor/log-viewer/custom-theme/logs
     * @test
     * @return void
     */
    public function masterCanSeeLogsPage(): void
    {
        $this->actingAs(factory(User::class)->create(['master' => 1]))
            ->get('/log-viewer/logs')
            ->assertSeeText(trans('logs.logs'))
            ->assertDontSeeText(trans('logs.page_is_not_avail'));
    }
}
