<?php

namespace Tests\Unit\Models;

use App\Models\Ban;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BanTest extends TestCase
{
    use DatabaseTransactions;

    public $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = create_user();
    }

    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Ban::class);
        $this->assertClassHasAttribute('table', Ban::class);
        $this->assertClassHasAttribute('timestamps', Ban::class);
    }

    /** @test */
    public function model_has_relationship_with_user(): void
    {
        $ban = Ban::make(['days' => 2, 'user_id' => $this->user->id]);
        $this->assertEquals($ban->user->id, $this->user->id);
    }

    /** @test */
    public function put_method_adds_user_to_ban_list(): void
    {
        Ban::put($this->user->id, 1, 'some message');
        $this->assertDatabaseHas('ban', [
            'user_id' => $this->user->id,
            'message' => 'some message',
            'days' => 1,
        ]);
    }
}
