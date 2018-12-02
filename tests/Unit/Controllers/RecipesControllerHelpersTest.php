<?php

namespace Tests\Unit\Controllers;

use App\Helpers\Traits\RecipesControllerHelpers;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RecipesControllerHelpersTest extends TestCase
{
    private $class;

    /**
     * @author Cho
     */
    public function setUp()
    {
        parent::setUp();
        $this->class = new class

        {use RecipesControllerHelpers;};
    }

    /**
     * @author Cho
     * @test
     */
    public function isSimple_method_returns_true_if_recipe_time_less_then_59(): void
    {
        $allowed_maximum_of_rows = config('custom.rows_for_simple_recipe');
        $recipe = new Recipe([
            'ingredients' => str_random(10),
            'text' => str_random(10),
            'time' => 59,
        ]);

        $request = Request::create(null, null, $recipe->toArray());
        $this->assertTrue($this->class->isSimple($recipe));
    }

    /**
     * @author Cho
     * @test
     */
    public function isSimple_method_returns_false_if_recipe_time_more_then_59(): void
    {
        $allowed_maximum_of_rows = config('custom.rows_for_simple_recipe');
        $recipe = new Recipe([
            'ingredients' => str_random(10),
            'text' => str_random(10),
            'time' => 60,
        ]);

        $request = Request::create(null, null, $recipe->toArray());
        $this->assertFalse($this->class->isSimple($recipe));
    }

    /**
     * More ditailes:
     * If allowed number of rows 20, and ingredients with text have 20 rows,
     * test must pass
     * @author Cho
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

        $request = Request::create(null, null, $recipe->toArray());
        $this->assertTrue($this->class->isSimple($recipe));
    }

    /**
     * More ditailes:
     * If allowed number of rows 20, and ingredients with text have 21 rows,
     * test must fail
     * @author Cho
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
        $request = Request::create(null, null, $recipe->toArray());
        $this->assertFalse($this->class->isSimple($recipe));
    }

    /**
     * @author Cho
     * @test
     */
    public function saveImageIfExist_method_uploads_file_and_saves_it_in_2_folders(): void
    {
        $image = UploadedFile::fake()->image('image.jpg');
        $filename = $this->class->saveImageIfExist($image, 'slug');

        $this->assertNotNull($filename);

        array_map(function ($dir) use ($filename) {
            $this->assertFileExists(storage_path("app/public/{$dir}/recipes/{$filename}"));
        }, ['small', 'big', 'blur']);

        $this->cleanAfterYourself($filename);
    }

    /**
     * @author Cho
     * @test
     */
    public function saveImageIfExist_method_returns_null_if_user_doent_have_a_file(): void
    {
        $filename = $this->class->saveImageIfExist(null, 'slug');

        $this->assertNull($filename);
    }

    /**
     * Helper function
     * @param string $filename
     * @author Cho
     * @return void
     */
    private function cleanAfterYourself(string $filename): void
    {
        \Storage::delete([
            "public/big/recipes/{$filename}",
            "public/small/recipes/{$filename}",
            "public/blur/recipes/{$filename}",
        ]);
    }
}
