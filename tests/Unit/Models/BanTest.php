<?php

namespace Tests\Unit\Models;

use App\Models\Ban;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BanTest extends TestCase
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
        $this->assertClassHasAttribute('guarded', Ban::class);
        $this->assertClassHasAttribute('table', Ban::class);
        $this->assertClassHasAttribute('timestamps', Ban::class);
    }

    /** @test */
    public function model_has_relationship_with_visitor(): void
    {
        $ban = Ban::make(['days' => 2, 'visitor_id' => $this->visitor->id]);
        $this->assertEquals($ban->visitor->id, $this->visitor->id);
    }

    /** @test */
    public function ban_visitor_method_adds_visitor_to_ban_list(): void
    {
        Ban::banVisitor($this->visitor->id, 1, 'some message');
        $this->assertDatabaseHas('ban', [
            'visitor_id' => $this->visitor->id,
            'message' => 'some message',
            'days' => 1,
        ]);
    }
}
