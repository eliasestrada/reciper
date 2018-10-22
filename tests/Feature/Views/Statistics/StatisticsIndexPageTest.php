<?php

namespace Tests\Feature\Views\Statistics;

use App\Models\User;
use Tests\TestCase;

class StatisticsPageTest extends TestCase
{
    /** @test */
    public function view_has_data(): void
    {
        $this->actingAs(make(User::class))
            ->get('/statistics')
            ->assertOk()
            ->assertViewIs('statistics.index')
            ->assertViewHasAll(['recipes', 'most_viewed', 'most_liked', 'most_favs']);
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/statistics')->assertRedirect();
    }
}
