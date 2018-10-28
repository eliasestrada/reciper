<?php

namespace Tests\Feature\Jobs;

use App\Jobs\DeleteImageJob;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Image;
use Tests\TestCase;

class DeleteImageJobTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function deleteImagesFromStorage_method_deletes_images(): void
    {
        $filename = $this->createFakeImages();
        $job = new DeleteImageJob($filename);
        $job->deleteImagesFromStorage();

        $this->assertFileNotExists(storage_path("app/public/recipes/{$filename}"));
        $this->assertFileNotExists(storage_path("app/public/small/recipes/{$filename}"));
    }

    /**
     * Function helper
     * @autho Cho
     * @return string
     */
    public function createFakeImages(): string
    {
        $filename = str_random(5) . '.jpg';

        $small_file = Image::make(UploadedFile::fake()->image('image.jpg'))
            ->save(storage_path("app/public/small/recipes/{$filename}"));

        $big_file = Image::make(UploadedFile::fake()->image('image.jpg'))
            ->save(storage_path("app/public/recipes/{$filename}"));

        return $filename;
    }
}
