<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function role_model_has_attributes(): void
    {
        $this->assertClassHasAttribute('timestamps', Role::class);
        $this->assertClassHasAttribute('guarded', Role::class);
    }

    /**
     * @author Cho
     * @test
     */
    public function role_model_has_relationship_with_user(): void
    {
        $role = Role::whereName('master')->first();
        $this->assertNotFalse($role->users);
    }
}
