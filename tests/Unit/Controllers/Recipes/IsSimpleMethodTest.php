<?php

namespace Tests\Unit\Controllers\Recipes;

use Tests\TestCase;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Helpers\Traits\RecipesControllerHelpers;

class IsSimpleMethodTest extends TestCase
{
    /** @test */
    public function isSimple_method_returns_true_if_recipe_time_less_then_59(): void
    {
        $allowed_maximum_of_rows = config('custom.rows_for_simple_recipe');
        $recipe = new Recipe([
            'ingredients' => str_random(10),
            'text' => str_random(10),
            'time' => 59,
        ]);

        $this->assertTrue($this->isSimple($recipe));
    }

    /** @test */
    public function isSimple_method_returns_false_if_recipe_time_more_then_59(): void
    {
        $allowed_maximum_of_rows = config('custom.rows_for_simple_recipe');
        $recipe = new Recipe([
            'ingredients' => str_random(10),
            'text' => str_random(10),
            'time' => 60,
        ]);

        $this->assertFalse($this->isSimple($recipe));
    }

    /**
     * More ditailes:
     * If allowed number of rows 20, and ingredients with text have 20 rows,
     * test must pass
     * @test
     * */
    public function isSimple_method_returns_true_if_rows_number_allowed(): void
    {
        $allowed_maximum_of_rows = config('custom.rows_for_simple_recipe');
        $recipe = new Recipe(['ingredients' => '', 'text' => '', 'time' => 40]);

        // Divide by 2 coz we have 2 values
        for ($i = 1; $i <= $allowed_maximum_of_rows / 2; $i++) {
            $recipe->ingredients .= "Row number $i \n";
            $recipe->text .= "Row number $i \n";
        }
        $this->assertTrue($this->isSimple($recipe));
    }
    
    /**
     * More ditailes:
     * If allowed number of rows 20, and ingredients with text have 21 rows,
     * test must fail
     * @test
     * */
    public function isSimple_method_returns_false_if_rows_more_then_allowed(): void
    {
        $allowed_maximum_of_rows = config('custom.rows_for_simple_recipe');
        $recipe = new Recipe(['ingredients' => '', 'text' => '', 'time' => 40]);

        // Divide by 2 coz we have 2 values and plus 1 to make it return false
        for ($i = 1; $i <= ($allowed_maximum_of_rows / 2) + 1; $i++) {
            $recipe->ingredients .= "Row number $i\n";
            $recipe->text .= "Row number $i\n";
        }
        $this->assertFalse($this->isSimple($recipe));
    }

    /**
     * Helper function to prevent repeating same code
     *
     * @param Recipe $recipe
     * @return bool
     */
    private function isSimple(Recipe $recipe): bool
    {
        $controller = new class { use RecipesControllerHelpers; };
        $request = Request::create(null, null, $recipe->toArray());
        return $controller->isSimple($request);
    }
}
