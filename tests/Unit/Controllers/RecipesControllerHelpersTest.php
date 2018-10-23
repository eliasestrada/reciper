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

    public function setUp()
    {
        parent::setUp();
        $this->class = new class

        {use RecipesControllerHelpers;};
    }

    /** @test */
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

    /** @test */
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

    /** @test */
    public function SaveImageIfExist_method_uploads_file_and_saves_it_in_2_folders(): void
    {
        $image = UploadedFile::fake()->image('image.jpg');
        $filename = $this->class->saveImageIfExist($image);

        $this->assertNotNull($filename);
        $this->assertFileExists(storage_path("app/public/recipes/$filename"));
        $this->assertFileExists(storage_path("app/public/small/recipes/$filename"));
        $this->cleanAfterYourself($filename);
    }

    /** @test */
    public function SaveImageIfExist_method_returns_null_if_user_doent_have_a_file(): void
    {
        $filename = $this->class->saveImageIfExist();
        $this->assertNull($filename);
    }

    /** @test */
    public function DeleteOldImage_method_deletes_files(): void
    {
        $image = UploadedFile::fake()->image('image.jpg');
        $filename = $this->class->saveImageIfExist($image);

        $this->class->deleteOldImage($filename);
        $this->assertFileNotExists(storage_path("app/public/recipes/$filename"));
        $this->assertFileNotExists(storage_path("app/public/small/recipes/$filename"));
    }

    /** @test */
    public function DeleteOldImage_method_doent_delete_files_if_name_is_default_jpg(): void
    {
        $this->class->DeleteOldImage('default.jpg');
        $this->assertFileExists(storage_path('app/public/recipes/default.jpg'));
        $this->assertFileExists(storage_path('app/public/small/recipes/default.jpg'));
    }

    /**
     * Helper function
     * @param string $filename
     * @return void
     */
    private function cleanAfterYourself(string $filename): void
    {
        \Storage::delete([
            "public/recipes/$filename",
            "public/small/recipes/$filename",
        ]);
    }
}
