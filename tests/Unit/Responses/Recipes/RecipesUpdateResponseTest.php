<?php

namespace Tests\Unit;

use File;
use Mockery;
use Storage;
use Tests\TestCase;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Responses\Controllers\Recipes\UpdateResponse;

class RecipesUpdateResponseTest extends TestCase
{
    /**
     * Function helper
     *
     * @param \App\Models\Recipe $recipe
     * @return \App\Http\Responses\Controllers\Recipes\UpdateResponse
     */
    private function classReponse(Recipe $recipe): UpdateResponse
    {
        $recipe_repo = Mockery::mock('App\Repos\RecipeRepo');
        $recipe_repo->shouldReceive('find')->once()->andReturn($recipe);

        return new UpdateResponse('some-slug', $recipe_repo);
    }

    /**
     * @author Cho
     * @test
     */
    public function method_isSimple_returns_true_if_recipe_time_less_then_59(): void
    {
        $recipe = Recipe::make([
            'ingredients' => str_random(10),
            'text' => str_random(10),
            'time' => 59,
        ]);
        $request = Request::create(null, null, $recipe->toArray());
        $response = $this->classReponse($recipe);
        $this->assertTrue($response->isSimple($request));
    }

    /**
     * @author Cho
     * @test
     */
    public function method_isSimple_returns_false_if_recipe_time_more_then_59(): void
    {
        $recipe = Recipe::make([
            'ingredients' => str_random(10),
            'text' => str_random(10),
            'time' => 60,
        ]);
        $request = Request::create(null, null, $recipe->toArray());
        $response = $this->classReponse($recipe);
        $this->assertFalse($response->isSimple($request));
    }

    /**
     * If allowed number of rows 20, and ingredients with text have 20 rows,
     * test must pass
     * 
     * @author Cho
     * @test
     * */
    public function method_isSimple_returns_true_if_rows_number_allowed(): void
    {
        $allowed_maximum_of_rows = config('custom.rows_for_simple_recipe');
        $recipe = Recipe::make(['ingredients' => '', 'text' => '', 'time' => 40]);

        // Divide by 2 coz we have 2 values
        for ($i = 1; $i <= $allowed_maximum_of_rows / 2; $i++) {
            $recipe->ingredients .= "Row number $i \n";
            $recipe->text .= "Row number $i \n";
        }

        $request = Request::create(null, null, $recipe->toArray());
        $response = $this->classReponse($recipe);

        $this->assertTrue($response->isSimple($request));
    }

    /**
     * If allowed number of rows 20, and ingredients with text have 21 rows,
     * test must fail
     * 
     * @author Cho
     * @test
     * */
    public function method_isSimple_returns_false_if_rows_more_then_allowed(): void
    {
        $allowed_maximum_of_rows = config('custom.rows_for_simple_recipe');
        $recipe = Recipe::make(['ingredients' => '', 'text' => '', 'time' => 40]);

        // Divide by 2 coz we have 2 values and plus 1 to make it return false
        for ($i = 1; $i <= ($allowed_maximum_of_rows / 2) + 1; $i++) {
            $recipe->ingredients .= "Row number $i\n";
            $recipe->text .= "Row number $i\n";
        }

        $request = Request::create(null, null, $recipe->toArray());
        $response = $this->classReponse($recipe);

        $this->assertFalse($response->isSimple($request));
    }

    /**
     * @author Cho
     * @test
     */
    public function method_saveImageIfExist_uploads_file_and_saves_it_in_2_folders(): void
    {
        $image = UploadedFile::fake()->image('image.jpg');
        $response = $this->classReponse(Recipe::make());
        $filename = $response->saveImageIfExist($image, 'slug');

        $this->assertNotNull($filename);

        array_map(function ($dir) use ($filename) {
            $this->assertFileExists(storage_path("app/public/{$dir}/recipes/{$filename}"));
        }, ['small', 'big']);

        // Clean after test by removing files
        Storage::delete([
            "public/big/recipes/{$filename}",
            "public/small/recipes/{$filename}",
        ]);
    }

    /**
     * @author Cho
     * @test
     */
    public function method_saveImageIfExist_returns_null_if_user_doent_have_a_file(): void
    {
        $response = $this->classReponse(Recipe::make());
        $filename = $response->saveImageIfExist(null, 'slug');
        $this->assertNull($filename);
    }

    /**
     * @author Cho
     * @test
     */
    public function method_fireEventAndRedirectWithSuccess_fires_event(): void
    {
        $this->expectsEvents(\App\Events\RecipeGotApproved::class);
        $this->classReponse(Recipe::make())->fireEventAndRedirectWithSuccess();
    }

    /**
     * @author Cho
     * @test
     */
    public function method_createDirectories_creates_directories_in_given_paths(): void
    {
        $directory = storage_path('framework/testing/' . str_random(5));
        $this->classReponse(Recipe::make())->createDirectories([$directory]);
        $this->assertDirectoryExists($directory);

        // Clean after test by removing created directory
        File::deleteDirectory($directory);
    }
}