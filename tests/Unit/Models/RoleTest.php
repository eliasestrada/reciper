<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('timestamps', Role::class);
    }

    /** @test */
    public function model_has_relationship_with_user(): void
    {
        $user = create(User::class);
        $user->addRole('admin');
        $this->assertCount(1, $user->roles);
    }
}
