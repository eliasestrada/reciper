<?php

namespace Tests\Unit\Models;

use App\Models\Ban;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class VisitorTest extends TestCase
{
    use DatabaseTransactions;

    public $visitor;

    public function setUp()
    {
        parent::setUp();
        $this->visitor = create(Visitor::class);
    }

    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('timestamps', Visitor::class);
    }

    /** @test */
    public function model_has_relationship_with_user(): void
    {
        create(User::class, ['visitor_id' => $this->visitor->id]);
        $this->assertNotNull($this->visitor->user);
    }

    /** @test */
    public function model_has_relationship_with_ban(): void
    {
        $ban = Ban::banVisitor($this->visitor->id, 1, '');
        $this->assertEquals($this->visitor->ban->id, $ban->id);
    }

    /** @test */
    public function is_banned_method_returns_true_if_user_in_banlist(): void
    {
        $this->assertFalse($this->visitor->isBanned());
        Ban::banVisitor($this->visitor->id, 1, '');
        $this->assertTrue($this->visitor->isBanned());
    }

    /** @test */
    public function is_banned_method_removes_visitor_from_banlist_after_a_term(): void
    {
        Ban::create([
            'visitor_id' => $this->visitor->id,
            'days' => 3,
            'message' => 'some message',
            'created_at' => now()->subDays(3),
        ]);

        $this->assertFalse($this->visitor->isBanned());
    }

    /** @test */
    public function is_banned_returns_true_if_user_in_banlist(): void
    {
        $this->assertFalse($this->visitor->isBanned());
        Ban::banVisitor($this->visitor->id, 1, '');
        $this->assertTrue($this->visitor->isBanned());
    }

    /** @test */
    public function get_status_color_method_returns_correct_color(): void
    {
        $this->assertEquals('main', $this->visitor->getStatusColor());

        $user = create(User::class, ['visitor_id' => $this->visitor->id]);
        $this->assertEquals('green', $user->visitor->getStatusColor());

        $banned_visitor = $this->visitor;
        Ban::banVisitor($banned_visitor->id, 1, 'some message');
        $this->assertEquals('red', $banned_visitor->getStatusColor());
    }
}
