<?php

namespace Tests\Unit\Models;

use App\Models\Ban;
use App\Models\User;
use App\Models\Visitor;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function model_has_attributes(): void
    {
        array_map(function ($attr) {
            $this->assertClassHasAttribute($attr, User::class);
        }, ['guarded', 'hidden', 'dates']);
    }

    /** @test */
    public function model_has_relationship_with_recipe(): void
    {
        $this->assertCount(0, make(User::class)->recipes);
    }

    /** @test */
    public function model_has_relationship_with_visitor(): void
    {
        $this->assertNotNull(make(User::class)->visitor);
    }

    /** @test */
    public function hasRole_method_returns_false_if_user_does_not_have_given_role(): void
    {
        $this->assertFalse(make(User::class)->hasRole('admin'));
    }

    /** @test */
    public function model_has_relationship_with_ban(): void
    {
        $user = make(User::class, ['id' => rand(9, 9999)]);
        $ban = Ban::put($user->id, 1, '', false);
        $user->setRelation('ban', $ban);
        $this->assertEquals($user->ban->id, $ban->id);
    }

    /** @test */
    public function isActive_method_returns_true_if_user_in_active(): void
    {
        $user = make(User::class);
        $this->assertTrue($user->isActive());
        $user = make(User::class, ['active' => 0]);
        $this->assertFalse($user->isActive());
    }

    /** @test */
    public function getName_method_return_name_if_no_name_returns_username(): void
    {
        $user = make(User::class, ['name' => 'Alex']);
        $this->assertEquals($user->name, $user->getName());
        $user = make(User::class, ['name' => null]);
        $this->assertEquals($user->username, $user->getName());
    }

    /** @test */
    public function getStatusColor_method_returns_red_if_user_is_not_active(): void
    {
        $user = make(User::class, ['active' => 0]);
        $this->assertEquals('red', $user->getStatusColor());
    }

    /** @test */
    public function getStatusColor_method_returns_green_if_user_is_active(): void
    {
        $user = make(User::class);
        $this->assertEquals('green', $user->getStatusColor());
    }

    /** @test */
    public function getStatusColor_method_returns_main_if_user_is_banned(): void
    {
        $user = $this->getMockBuilder(User::class)
            ->setMethodsExcept(['getStatusColor'])
            ->getMock();
        $user->method('isBanned')->willReturn(true);

        $this->assertEquals('main', $user->getStatusColor());
    }
}
