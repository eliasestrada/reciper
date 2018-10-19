<?php

namespace Tests\Feature\Models;

use App\Models\Ban;
use App\Models\User;
use Tests\TestCase;

class BanTest extends TestCase
{
    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Ban::class);
        $this->assertClassHasAttribute('table', Ban::class);
        $this->assertClassHasAttribute('timestamps', Ban::class);
    }

    /** @test */
    public function put_method_adds_user_to_ban_list(): void
    {
        $user = make(User::class, ['id' => rand(2, 10000)]);
        $output = Ban::put($user->id, 1, 'some message', false);
        $this->assertEquals($output->user_id, $user->id);
    }
}
