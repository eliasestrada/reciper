<?php

namespace Tests\Unit\Models;

use App\Models\Ban;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BanTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Ban::class);
        $this->assertClassHasAttribute('table', Ban::class);
        $this->assertNull(Ban::UPDATED_AT);
    }

    /** @test */
    public function model_has_relationship_with_visitor(): void
    {
        $visitor = create(Visitor::class);
        $ban = Ban::make(['days' => 2, 'visitor_id' => $visitor->id]);

        $this->assertEquals($ban->visitor->id, $visitor->id);
    }

    /** @test */
    public function ban_visitor_method_adds_visitor_to_ban_list(): void
    {
        $visitor = create(Visitor::class);
        Ban::banVisitor($visitor->id, 1, 'some message');

        $this->assertDatabaseHas('ban', [
            'visitor_id' => $visitor->id,
            'message' => 'some message',
            'days' => 1,
        ]);
    }
}
