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
    public function userCanSee_ThePage(): void
    {
        $this->actingAs(make(User::class))->get('/notifications')->assertViewIs('notifications.index')->assertOk();
    }

    /** @test */
    public function guestCantSee_ThePage(): void
    {
        $this->get('/notifications')->assertRedirect('/login');
    }

    /** @test */
    public function userCanRecive_RecipeApprovedNotification(): void
    {
        $user = create_user();
        $recipe = make(Recipe::class, ['user_id' => $user->id]);
        $user->notify(new RecipeApprovedNotification($recipe));

        $this->actingAs($user)
            ->get('/notifications')
            ->assertSeeText(trans('approves.recipe_published'));
    }

    /** @test */
    public function firstUserCanRecive_ScriptAttackNotification(): void
    {
        $first = User::first();
        $first->notify(new ScriptAttackNotification(create_user()->username));

        $this->actingAs($first)
            ->get('/notifications')
            ->assertSeeText(trans('notifications.title_script_attack'));
    }
}
