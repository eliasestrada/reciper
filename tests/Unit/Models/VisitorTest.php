<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Visitor;

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
}
