<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\View;

class ViewTest extends TestCase
{
    /**
     * @test
     */
    public function view_model_has_attributes(): void
    {
        $this->assertClassHasAttribute('guarded', View::class);
        $this->assertClassHasAttribute('timestamps', View::class);
    }
}
