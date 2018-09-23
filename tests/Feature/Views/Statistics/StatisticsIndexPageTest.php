<?php

namespace Tests\Feature\Views\Statistics;

use App\Models\Recipe;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StatisticsPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $user = create_user();

        $this->actingAs($user)
            ->get('/statistics')
            ->assertViewIs('statistics.index')
            ->assertViewHasAll([
                'visitors' => Visitor::latest()->paginate(40)->onEachSide(1),
                'all_recipes' => Recipe::count(),
                'all_visitors' => Visitor::distinct('ip')->count(),
            ]);
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/statistics')->assertRedirect();
    }
}
