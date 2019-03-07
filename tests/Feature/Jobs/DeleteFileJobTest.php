<?php

namespace Tests\Feature\Jobs;

use Storage;
use Tests\TestCase;
use App\Jobs\DeleteFileJob;

class DeleteFileJobTest extends TestCase
{
    /**
     * @test
     */
    public function deleteFile_method_deletes_given_file_from_storage(): void
    {
        Storage::put('test.txt', 'Some text');
        $this->assertFileExists(storage_path('app/test.txt'));

        (new DeleteFileJob('test.txt'))->deleteFile();
        $this->assertFileNotExists(storage_path('app/test.txt'));
    }
}
