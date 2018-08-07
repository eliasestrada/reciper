<?php

namespace Tests\Feature\Views\Admin\Statistics;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminStatisticsPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * resources/views/admin/statistics/index
     * @return void
     * @test
     */
    public function view_admin_statistics_index_has_data(): void
    {
        $admin = factory(User::class)->make(['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/statistics')
            ->assertViewIs('admin.statistics.index')
            ->assertViewHasAll(['sxgeo', 'visitors', 'allrecipes', 'allvisitors']);
    }

    /**
     * resources/views/admin/statistics/index
     * @return void
     * @test
     */
    public function user_cant_see_admin_statistics_index_page(): void
    {
        $this->actingAs(factory(User::class)->make(['admin' => 0]))
            ->get('/admin/statistics')
            ->assertRedirect('/login');
    }
}
