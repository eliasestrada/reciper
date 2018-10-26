<?php

namespace Tests\Feature\Views\Statistics;

use App\Models\User;
use Tests\TestCase;

class StatisticsPageTest extends TestCase
{
    /**
     * @author Cho
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
     * @author Cho
     * @test
     */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/statistics')->assertRedirect();
    }
}
