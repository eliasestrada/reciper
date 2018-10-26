<?php

namespace Tests\Feature\Views\Notifications;

use App\Models\Recipe;
use App\Models\User;
use App\Notifications\RecipeApprovedNotification;
use App\Notifications\RecipeCanceledNotification;
use App\Notifications\ScriptAttackNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NotificationsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))
            ->get('/notifications')
            ->assertViewIs('notifications.index')
            ->assertOk();
    }

    /**
     * @author Cho
     * @test
     */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/notifications')->assertRedirect();
    }

    /**
     * @author Cho
     * @test
     */
    public function user_can_recive_RecipeApprovedNotification(): void
    {
        $user = create_user();
        $recipe = make(Recipe::class, ['user_id' => $user->id]);
        $user->notify(new RecipeApprovedNotification($recipe));

        $this->actingAs($user)
            ->get('/notifications')
            ->assertSeeText(trans('approves.recipe_published'));
    }

    /**
     * @author Cho
     * @test
     */
    public function user_can_recive_RecipeCanceledNotification(): void
    {
        $user = create_user();
        $recipe = make(Recipe::class, ['user_id' => $user->id]);
        $user->notify(new RecipeCanceledNotification($recipe, 'some message'));

        $this->actingAs($user)
            ->get('/notifications')
            ->assertSeeText(trans('approves.recipe_not_published'));
    }

    /**
     * @author Cho
     * @test
     */
    public function first_user_can_recive_script_attack_notification(): void
    {
        $first = User::first();
        $first->notify(new ScriptAttackNotification(create_user()->username));

        $this->actingAs($first)
            ->get('/notifications')
            ->assertSeeText(trans('notifications.title_script_attack'));
    }
}
