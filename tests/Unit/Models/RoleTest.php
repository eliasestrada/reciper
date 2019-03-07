<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Role;

class RoleTest extends TestCase
{
    /**
     * @test
     */
    public function role_model_has_attributes(): void
    {
        $this->assertClassHasAttribute('timestamps', Role::class);
        $this->assertClassHasAttribute('guarded', Role::class);
    }

    /**
     * @test
     */
    public function role_model_has_relationship_with_user(): void
    {
        $role = Role::whereName('master')->first();
        $this->assertNotFalse($role->users);
    }
}
