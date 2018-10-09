<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MiddlewaresTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function updated_at_is_updated_to_now_aftet_user_visits_the_app(): void
    {
        $this->actingAs($user = create_user('', ['updated_at' => now()->subWeek()]))->get('/');
        $now = now();
        $this->assertDatabaseHas('users', ['id' => $user->id, 'updated_at' => $now]);
    }

    /** @test */
    public function updated_at_is_updated_after_5_minutes(): void
    {
        $this->actingAs($user = create_user('', ['updated_at' => now()->subMinutes(5)]))->get('/');
        $now = now();
        $this->assertDatabaseHas('users', ['id' => $user->id, 'updated_at' => $now]);
    }

    /** @test */
    public function updated_at_is_not_updated_after_first_visit_within_5_minutes(): void
    {
        $user = create_user();

        for ($i = 1; $i < 5; $i++) {
            $date = now()->subMinutes($i);
            $user->update(['updated_at' => $date]);
            $this->actingAs($user)->get('/');
            $this->assertDatabaseHas('users', ['id' => $user->id, 'updated_at' => $date]);
        }
    }
}
