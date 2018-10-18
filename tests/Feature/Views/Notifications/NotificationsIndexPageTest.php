<?php

namespace Tests\Feature\Views\Notifications;

use App\Models\Recipe;
use App\Models\User;
use App\Notifications\RecipeApprovedNotification;
use App\Notifications\ScriptAttackNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NotificationsIndexPageTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function user_can_see_the_page(): void
    {
        $this->actingAs(make(User::class))->get('/notifications')->assertViewIs('notifications.index')->assertOk();
    }

    /** @test */
    public function guest_cant_see_the_page(): void
    {
        $this->get('/notifications')->assertRedirect('/login');
    }

    /** @test */
    public function user_can_recive_recipe_approved_notification(): void
    {
        $user = create_user();
        $recipe = make(Recipe::class, ['user_id' => $user->id]);
        $user->notify(new RecipeApprovedNotification($recipe));

        $this->actingAs($user)
            ->get('/notifications')
            ->assertSeeText(trans('approves.recipe_published'));
    }

    /** @test */
    public function first_user_can_recive_script_attack_notification(): void
    {
        $first = User::first();
        $first->notify(new ScriptAttackNotification(create_user()->username));

        $this->actingAs($first)
            ->get('/notifications')
            ->assertSeeText(trans('notifications.title_script_attack'));
    }
}
