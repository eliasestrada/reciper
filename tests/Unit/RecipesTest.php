<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipesTest extends TestCase
{
	use DatabaseTransactions;

    public function testWithRelationship()
    {
        $categories = DB::table('categories')->get()->toArray();

		dd($categories);
    }
}
