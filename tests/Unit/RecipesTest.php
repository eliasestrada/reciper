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
		
		$categories = array_map(function($category) {
			return $category->category;
		}, $categories);

		dd($categories);
    }
}
