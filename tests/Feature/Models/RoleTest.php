<?php

namespace Tests\Feature\Models;

use App\Models\Role;
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
        $this->assertCount(1, create_user('admin')->roles);
    }
}
