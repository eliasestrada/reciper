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
    public function is_banned_returns_true_if_user_in_banlist(): void
    {
        $this->assertFalse($this->visitor->isBanned());
        Ban::banVisitor($this->visitor->id, 1, '');
        $this->assertTrue($this->visitor->isBanned());
    }
}
