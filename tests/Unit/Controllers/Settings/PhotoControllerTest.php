<?php

namespace Tests\Unit\Controllers\Settings;

use App\Helpers\Traits\PhotoControllerHelpers;
use Illuminate\Http\UploadedFile;
use Storage;
use Tests\TestCase;

class PhotoControllerTest extends TestCase
{
    private $class;

    public function setUp()
    {
        parent::setUp();
        $this->class = new class

        {use PhotoControllerHelpers;};
    }

    /** @test */
    public function SaveImageIfExist_method_uploads_file_and_saves_it_in_2_folders(): void
    {
        $image = UploadedFile::fake()->image('image.jpg');
        $filename = $this->class->saveImageIfExist($image);
        $path_slug = $this->class->makePathSlug();

        $this->assertNotNull($filename);
        $this->assertFileExists(storage_path("app/public/users/$path_slug/$filename"));
        $this->assertFileExists(storage_path("app/public/small/users/$path_slug/$filename"));
        $this->cleanAfterYourself("$path_slug/$filename");
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
        $path_to_image = $this->class->saveImageIfExist($image);

        $this->class->deleteOldImage($path_to_image);
        $this->assertFileNotExists(storage_path("app/public/users/$path_to_image"));
        $this->assertFileNotExists(storage_path("app/public/small/users/$path_to_image"));
    }

    /** @test */
    public function DeleteOldImage_method_doent_delete_files_if_name_is_default_jpg(): void
    {
        $this->class->DeleteOldImage('default.jpg');
        $this->assertFileExists(storage_path('app/public/users/default.jpg'));
        $this->assertFileExists(storage_path('app/public/small/users/default.jpg'));
    }

    /**
     * Helper function
     * @param string $image_path
     * @return void
     */
    private function cleanAfterYourself(string $image_path): void
    {
        // \Storage::delete([
        //     "public/users/$image_path",
        //     "public/small/users/$image_path",
        // ]);
        Storage::delete("public/users/$image_path");
        Storage::delete("public/small/users/$image_path");
    }
}
