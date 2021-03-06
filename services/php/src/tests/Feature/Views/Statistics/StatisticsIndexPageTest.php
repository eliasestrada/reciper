<?php

namespace Tests\Feature\Views\Statistics;

use Tests\TestCase;
use App\Models\User;

class StatisticsPageTest extends TestCase
{
    /**
     * @test
     */
    public function user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/statistics')
            ->assertOk()
            ->assertViewIs('statistics.index');
    }

    /**
     * @test
     */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/statistics')->assertRedirect();
    }
}
