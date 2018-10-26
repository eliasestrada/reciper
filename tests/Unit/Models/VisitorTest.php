<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Visitor;
use Tests\TestCase;

class VisitorTest extends TestCase
{
    /**
     * @author Cho
     * @test
     */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('timestamps', Visitor::class);
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusColor_method_returns_correct_color(): void
    {
        // Red color
        $visitor = make(Visitor::class);
        $this->assertEquals('red', $visitor->getStatusColor());

        // Green color
        $user = make(User::class, ['id' => $id = rand(3, 10000), 'visitor_id' => $id]);
        $visitor = make(Visitor::class, ['id' => $id]);

        $user->setRelation('visitor', $visitor);
        $visitor->setRelation('user', $user);

        $this->assertEquals('green', $user->visitor->getStatusColor());
    }
}
