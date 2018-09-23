<?php

namespace Tests\Feature\Views\Statistics;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StatisticsPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $user = create_user();

        $recipes = Recipe::whereUserId($user->id)
            ->select('id', 'title_' . lang())
            ->withCount('likes')
            ->withCount('views')
            ->get();

        $most_viewed = $recipes->where('views_count', $recipes->max('views_count'))->first();
        $most_liked = $recipes->where('likes_count', $recipes->max('likes_count'))->first();

        $this->actingAs($user)
            ->get('/statistics')
            ->assertViewIs('statistics.index')
            ->assertViewHasAll(compact('recipes', 'most_viewed', 'most_liked'));
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/statistics')->assertRedirect();
    }
}
