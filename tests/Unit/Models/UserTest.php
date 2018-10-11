<?php

namespace Tests\Unit\Models;

use App\Models\Ban;
use App\Models\Fav;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', User::class);
        $this->assertClassHasAttribute('hidden', User::class);
        $this->assertClassHasAttribute('dates', User::class);
    }

    /** @test */
    public function model_has_relationship_with_recipe(): void
    {
        $this->assertCount(0, make(User::class)->recipes);
    }

    /** @test */
    public function model_has_relationship_with_role(): void
    {
        $this->assertNotNull(create_user('admin')->roles);
    }

    /** @test */
    public function model_has_relationship_with_favs(): void
    {
        $this->assertNotNull(create_user()->favs);
    }

    /** @test */
    public function model_has_relationship_with_notification(): void
    {
        $this->assertNotNull(make(User::class)->notifications);
    }

    /** @test */
    public function model_has_relationship_with_visitor(): void
    {
        $this->assertNotNull(make(User::class)->visitor);
    }

    /** @test */
    public function has_role_method_returns_true_if_user_has_given_role(): void
    {
        $this->assertFalse(create_user()->hasRole('admin'));
        $this->assertTrue(create_user('admin')->hasRole('admin'));
    }

    /** @test */
    public function add_role_method_adds_role_to_given_user(): void
    {
        $user = create_user();
        $user->addRole('master');
        $this->assertTrue($user->hasRole('master'));
    }

    /** @test */
    public function has_recipe_method_returns_true_if_user_is_an_author_of_the_given_recipe_id(): void
    {
        $user = make(User::class);
        $recipe = create(Recipe::class, ['user_id' => $user->id]);
        $this->assertTrue($user->hasRecipe($recipe->id));
    }

    /** @test */
    public function has_fav_method_returns_bool_if_user_has_this_recipe_in_favs(): void
    {
        $user = make(User::class);
        $recipe = create(Recipe::class);
        Fav::create(['user_id' => $user->id, 'recipe_id' => $recipe->id]);
        $this->assertTrue($user->hasFav($recipe->id));
    }

    /** @test */
    public function model_has_relationship_with_ban(): void
    {
        $user = create_user();
        $ban = Ban::put($user->id, 1, '');
        $this->assertEquals($user->ban->id, $ban->id);
    }

    /** @test */
    public function is_banned_method_returns_true_if_user_in_banlist(): void
    {
        $user = create_user();
        $this->assertFalse($user->isBanned());
        Ban::put($user->id, 1, '');
        $this->assertTrue($user->isBanned());
    }

    /** @test */
    public function is_banned_method_removes_user_from_banlist_after_a_term(): void
    {
        $user = create_user();
        Ban::create([
            'user_id' => $user->id,
            'days' => 3,
            'message' => 'some message',
            'created_at' => now()->subDays(3),
        ]);

        $this->assertFalse($user->isBanned());
    }

    /** @test */
    public function is_banned_returns_true_if_user_in_banlist(): void
    {
        $user = create_user();
        $this->assertFalse($user->isBanned());
        Ban::put($user->id, 1, '');
        $this->assertTrue($user->isBanned());
    }
}
