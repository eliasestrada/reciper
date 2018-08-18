<?php

namespace Tests\Unit\Models;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @return void
     */
    public function model_has_properies(): void
    {
        $this->assertClassHasAttribute('guarded', Notification::class);
    }

    /**
     * @test
     * @return void
     */
    public function model_has_relationship_with_user(): void
    {
        $user = create(User::class);
        $notif = Notification::create([
            'user_id' => $user->id,
            'title' => 'hello_world',
            'message' => 'message_goes_here',
        ]);

        $this->assertTrue($notif->user()->exists());
        $this->assertEquals($user->id, $notif->user->id);
    }

}
