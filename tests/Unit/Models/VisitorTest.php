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
    public function visitor_model_has_attributes(): void
    {
        $this->assertClassHasAttribute('timestamps', Visitor::class);
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusColor_method_returns_RED_color_if_visitor_is_not_registered(): void
    {
        $visitor = make(Visitor::class);
        $this->assertEquals('red', $visitor->getStatusColor());
    }

    /**
     * @author Cho
     * @test
     */
    public function getStatusColor_method_returns_GREEN_color_when_visitor_is_registered(): void
    {
        $user = make(User::class, ['id' => $id = rand(3, 10000), 'visitor_id' => $id]);
        $visitor = make(Visitor::class, ['id' => $id]);

        $user->setRelation('visitor', $visitor);
        $visitor->setRelation('user', $user);

        $this->assertEquals('green', $user->visitor->getStatusColor());
    }
}
