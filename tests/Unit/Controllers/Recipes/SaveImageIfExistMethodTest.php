<?php

namespace Tests\Unit\Controllers\Recipes;

use App\Helpers\Traits\RecipesControllerHelpers;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SaveImageIfExistMethodTest extends TestCase
{
    private $class;

    public function setUp()
    {
        parent::setUp();
        $this->class = new class

        {use RecipesControllerHelpers;};
    }

    /** @test */
    public function file_can_be_uploaded(): void
    {
        $image = UploadedFile::fake()->image('image.jpg');
        $filename = $this->class->saveImageIfExist($image);

        $this->assertNotNull($filename);
        $this->assertFileExists(storage_path("app/public/recipes/$filename"));
        $this->assertFileExists(storage_path("app/public/small/recipes/$filename"));
        $this->cleanAfterYourself($filename);
    }

    /** @test */
    public function if_user_doent_have_a_file_returns_null(): void
    {
        $filename = $this->class->saveImageIfExist();
        $this->assertNull($filename);
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
