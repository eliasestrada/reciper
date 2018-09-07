<?php

namespace Tests\Feature\Views\Admin\Statistics;

use App\Models\Recipe;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminStatisticsPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_admin_statistics_index_has_data(): void
    {
        $admin = make(User::class, ['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/statistics')
            ->assertViewIs('admin.statistics.index')
            ->assertViewHas('sxgeo')
            ->assertViewHasAll([
                'visitors' => Visitor::latest()->paginate(40)->onEachSide(1),
                'all_recipes' => Recipe::count(),
                'all_visitors' => Visitor::distinct('ip')->count(),
            ]);
    }

    /** @test */
    public function user_cant_see_admin_statistics_index_page(): void
    {
        $this->actingAs(make(User::class, ['admin' => 0]))
            ->get('/admin/statistics')
            ->assertRedirect('/');
    }
}
