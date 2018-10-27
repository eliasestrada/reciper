<?php

namespace Tests\Unit\Models;

use App\Models\Ban;
use App\Models\User;
use App\Models\Visitor;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function model_has_attributes(): void
    {
        array_map(function ($attr) {
            $this->assertClassHasAttribute($attr, User::class);
        }, ['guarded', 'hidden', 'dates']);
    }

    /**
     * @author Cho
     * @test
     */
    public function model_has_relationship_with_recipe(): void
    {
        $this->assertCount(0, make(User::class)->recipes);
    }

    /**
     * @author Cho
     * @test
     */
    public function model_has_relationship_with_favs(): void
    {
        $this->assertNotNull(User::first()->favs);
    }

    /**
     * @author Cho
     * @test
     */
    public function model_has_relationship_with_visitor(): void
    {
        $this->assertNotNull(make(User::class)->visitor);
    }

    /**
     * @author Cho
     * @test
     */
    public function hasRole_method_returns_false_if_user_does_not_have_given_role(): void
    {
        $this->assertFalse(make(User::class)->hasRole('admin'));
    }

    /**
     * Ban::put() last param is set to false which means that instead of creating
     * ban record in DB just make it in memory
     * @author Cho
     * @test
     */
    public function user_has_relationship_with_ban_model(): void
    {
        $user = User::first();
        $ban = Ban::put($user->id, 1, '', false);
        $user->setRelation('ban', $ban);
        $this->assertEquals($user->ban->id, $ban->id);
    }

    /**
     * @author Cho
     * @test
     */
    public function isActive_method_returns_true_if_user_in_active(): void
    {
        $user = make(User::class);
        $this->assertTrue($user->isActive());
        $user = make(User::class, ['active' => 0]);
        $this->assertFalse($user->isActive());
    }

    /**
     * @author Cho
     * @test
     */
    public function getName_method_return_name_if_no_name_returns_username(): void
    {
        $user = make(User::class, ['name' => 'Alex']);
        $this->assertEquals($user->name, $user->getName());
        $user = make(User::class, ['name' => null]);
        $this->assertEquals($user->username, $user->getName());
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusColor_method_returns_red_if_user_is_not_active(): void
    {
        $user = make(User::class, ['active' => 0]);
        $this->assertEquals('red', $user->getStatusColor());
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusColor_method_returns_green_if_user_is_active(): void
    {
        $user = make(User::class);
        $this->assertEquals('green', $user->getStatusColor());
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusColor_method_returns_main_if_user_is_banned(): void
    {
        $user = $this->getMockBuilder(User::class)
            ->setMethodsExcept(['getStatusColor'])
            ->getMock();
        $user->method('isBanned')->willReturn(true);

        $this->assertEquals('main', $user->getStatusColor());
    }
}
