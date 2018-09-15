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
    public function view_has_data(): void
    {
        $admin = create_user('admin');

        $this->actingAs($admin)
            ->get('/admin/statistics')
            ->assertViewIs('admin.statistics.index')
            ->assertViewHasAll([
                'visitors' => Visitor::latest()->paginate(40)->onEachSide(1),
                'all_recipes' => Recipe::count(),
                'all_visitors' => Visitor::distinct('ip')->count(),
            ]);
    }

    /** @test */
    public function user_cant_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/admin/statistics')
            ->assertRedirect('/');
    }
}
