<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('timestamps', Role::class);
    }
}
