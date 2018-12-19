<?php

namespace Tests\Feature\Jobs;

use App\Jobs\DeleteFileJob;
use Storage;
use Tests\TestCase;

class DeleteFileJobTest extends TestCase
{
    /**
     * @author Cho
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
