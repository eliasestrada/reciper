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
    public function deleteNotDefaultPhoto_method_deletes_photo(): void
    {
        $filename = $this->createFakePhoto();
        $job = new DeletePhotoJob($filename);
        $job->deleteNotDefaultPhoto();

        $this->assertFileNotExists(storage_path("app/public/small/users/{$filename}"));
    }

    /**
     * Function helper
     * @autho Cho
     * @return string
     */
    public function createFakePhoto(): string
    {
        $filename = str_random(5) . '.jpg';

        \Image::make(UploadedFile::fake()->image('image.jpg'))
            ->save(storage_path("app/public/small/users/{$filename}"));

        return $filename;
    }
}
