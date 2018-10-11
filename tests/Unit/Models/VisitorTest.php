<?php

namespace Tests\Unit\Models;

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
    public function get_status_color_method_returns_correct_color(): void
    {
        $this->assertEquals('red', $this->visitor->getStatusColor());

        $user = create(User::class, ['visitor_id' => $this->visitor->id]);
        $this->assertEquals('green', $user->visitor->getStatusColor());
    }
}
