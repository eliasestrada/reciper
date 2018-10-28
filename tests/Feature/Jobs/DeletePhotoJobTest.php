<?php

namespace Tests\Feature\Jobs;

use App\Jobs\DeletePhotoJob;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DeletePhotoJobTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @author Cho
     * @test
     */
    public function deletePhotosFromStorage_method_deletes_photos(): void
    {
        $filename = $this->createFakePhotos();
        $job = new DeletePhotoJob($filename);
        $job->deletePhotosFromStorage();

        $this->assertFileNotExists(storage_path("app/public/users/{$filename}"));
        $this->assertFileNotExists(storage_path("app/public/small/users/{$filename}"));
    }

    /**
     * Function helper
     * @autho Cho
     * @return string
     */
    public function createFakePhotos(): string
    {
        $filename = str_random(5) . '.jpg';

        \Image::make(UploadedFile::fake()->image('image.jpg'))
            ->save(storage_path("app/public/users/{$filename}"));

        \Image::make(UploadedFile::fake()->image('image.jpg'))
            ->save(storage_path("app/public/small/users/{$filename}"));

        return $filename;
    }
}
