<?php

namespace Tests\Feature\Views\Master\Visitors;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MasterVisitorsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function view_has_data(): void
    {
        $this->actingAs(create_user('master'))
            ->get('/master/visitors')
            ->assertOk()
            ->assertViewIs('master.visitors.index')
            ->assertViewHas('visitors');
    }

    /** @test */
    public function admin_cant_view_the_page(): void
    {
        $this->actingAs(create_user('admin'))
            ->get('/master/visitors')
            ->assertRedirect();
    }

    /** @test */
    public function user_cant_view_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/master/visitors')
            ->assertRedirect();
    }
}
