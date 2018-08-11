<?php

namespace Tests\Unit\Models;

use App\Models\Feedback;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', Feedback::class);
    }
}
