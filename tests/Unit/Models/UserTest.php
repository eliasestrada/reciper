<?php

namespace Tests\Unit\Models;

use App\Models\Ban;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function user_model_has_attributes(): void
    {
        array_map(function ($attr) {
            $this->assertClassHasAttribute($attr, User::class);
        }, ['guarded', 'hidden', 'dates']);
    }

    /**
     * @author Cho
     * @test
     */
    public function user_model_has_relationship_with_recipe_model(): void
    {
        $this->assertCount(0, make(User::class)->recipes);
    }

    /**
     * @author Cho
     * @test
     */
    public function user_model_has_relationship_with_fav_model(): void
    {
        $this->assertNotNull(User::first()->favs);
    }

    /**
     * Ban::put() last param is set to false which means that instead of creating
     * ban record in DB just make it in memory
     * @author Cho
     * @test
     */
    public function user_model_has_relationship_with_ban_model(): void
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
    public function hasRole_method_returns_false_if_user_does_not_have_given_role(): void
    {
        $this->assertFalse(make(User::class)->hasRole('admin'));
    }

    /**
     * @author Cho
     * @test
     */
    public function isActive_method_returns_true_if_table_column_active_is_set_to_1(): void
    {
        $user = make(User::class);
        $this->assertTrue($user->isActive());
    }

    /**
     * @author Cho
     * @test
     */
    public function isActive_method_returns_fasle_if_table_column_active_is_set_to_0(): void
    {
        $user = make(User::class, ['active' => 0]);
        $this->assertFalse($user->isActive());
    }

    /**
     * @author Cho
     * @test
     */
    public function getName_method_returns_name_if_column_name_is_not_null(): void
    {
        $user = make(User::class, ['name' => 'Alex']);
        $this->assertEquals($user->name, $user->getName());
    }

    /**
     * @author Cho
     * @test
     */
    public function getName_method_returns_username_if_name_column_is_null(): void
    {
        $user = make(User::class, ['name' => null]);
        $this->assertEquals($user->username, $user->getName());
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusColor_method_returns_RED_color_if_user_is_not_active(): void
    {
        $user = make(User::class, ['active' => 0]);
        $this->assertEquals('red', $user->getStatusColor());
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusColor_method_returns_GREEN_color_if_user_is_active(): void
    {
        $user = make(User::class);
        $this->assertEquals('green', $user->getStatusColor());
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusColor_method_returns_MAIN_color_if_user_is_banned(): void
    {
        $user = $this->getMockBuilder(User::class)
            ->setMethodsExcept(['getStatusColor'])
            ->getMock();
        $user->method('isBanned')->willReturn(true);

        $this->assertEquals('main', $user->getStatusColor());
    }

    /**
     * @author Cho
     * @test
     */
    public function verified_method_returns_true_if_user_has_token_field_empty(): void
    {
        $virified_user = User::first();
        $this->assertTrue($virified_user->verified());
    }
}
