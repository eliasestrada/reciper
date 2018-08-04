<?php

namespace Tests\Feature\Views\Admin\Checklist;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminChecklistIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function viewAdminChecklistIndexHasData(): void
    {
        $admin = factory(User::class)->make(['admin' => 1]);

        $this->actingAs($admin)
            ->get('/admin/checklist')
            ->assertOk()
            ->assertViewIs('admin.checklist.index')
            ->assertViewHas('unapproved');
    }

    /**
     * Test for checklist page. View: resources/views/admin/checklist/index
     * @return void
     * @test
     */
    public function userCantSeeAdminChecklistIndexPage(): void
    {
        $user = factory(User::class)->make(['admin' => 0]);

        $this->actingAs($user)
            ->get('/admin/checklist')
            ->assertRedirect('/login');
    }
}
