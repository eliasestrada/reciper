<?php

namespace Tests\Unit\Models;

use App\Models\Ban;
use Tests\TestCase;
use App\Models\User;

class BanTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function ban_model_has_attributes(): void
    {
        array_map(function ($attr) {
            $this->assertClassHasAttribute($attr, Ban::class);
        }, ['guarded', 'table', 'timestamps']);
    }

    /**
     * @author Cho
     * @test
     */
    public function put_method_adds_user_to_ban_list(): void
    {
        $user = make(User::class, ['id' => rand(2, 10000)]);
        $output = Ban::put($user->id, 1, 'some message', false);
        $this->assertEquals($output->user_id, $user->id);
    }

    /**
     * @author Cho
     * @test
     */
    public function ban_model_has_relationship_with_user_model(): void
    {
        $ban = Ban::make([
            'user_id' => 1,
            'days' => 1,
            'message' => 'some message',
        ]);
        $this->assertTrue($ban->user->exists());
    }
}
