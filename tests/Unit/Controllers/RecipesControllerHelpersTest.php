<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Helpers\Controllers\RecipeHelpers;
use App\Notifications\ScriptAttackNotification;

class RecipeControllerHelpersTest extends TestCase
{
    /**
     * @var \App\Helpers\Controllers\RecipeHelpers $class
     */
    private $class;

    /**
     * @author Cho
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->class = new class { use RecipeHelpers; };
    }

    /**
     * @author Cho
     */
    public function tearDown(): void
    {
        \File::cleanDirectory(storage_path('logs'));
        parent::tearDown();
    }

    /**
     * @author Cho
     * @test
     */
    public function method_checkForScriptTags_returns_true_if_title_has_script_tag(): void
    {
        $this->withoutNotifications();
        $this->class->checkForScriptTags(['title' => 'Lorem <script'], make(User::class));
    }

    /**
     * @author Cho
     * @test
     */
    public function method_checkForScriptTags_returns_false_if_title_has_no_script_tag(): void
    {
        $this->withoutNotifications();
        $this->assertFalse($this->class->checkForScriptTags([
            'title' => 'Lorem ipsum title'
        ]), make(User::class));
    }

    /**
     * @author Cho
     * @test
     */
    public function method_checkForScriptTags_notifies_master_user_about_a_script_attack(): void
    {
        $this->expectsNotification(User::firstUser(), ScriptAttackNotification::class);
        $this->class->checkForScriptTags([
            'text' => 'Lorem ipsum title <script> hello'
        ], make(User::class));
    }

    /**
     * @author Cho
     * @test
     */
    public function method_checkForScriptTags_creates_logs_about_a_script_attack(): void
    {
        $date = date('Y-m-d');
        $this->assertFileNotExists(storage_path("logs/laravel-{$date}.log"));

        $this->withoutNotifications();
        $this->class->checkForScriptTags([
            'ingredients' => 'Lorem ipsum title <script> hello'
        ], make(User::class));

        $this->assertFileExists(storage_path("logs/laravel-{$date}.log"));
    }

    /**
     * @author Cho
     * @test
     */
    public function method_dispatchDeleteFileJob_dispatches_the_job(): void
    {
        $this->expectsJobs(\App\Jobs\DeleteFileJob::class);
        $this->class->dispatchDeleteFileJob('lorem.jpg');
    }

    /**
     * @author Cho
     * @test
     */
    public function method_dispatchDeleteFileJob_not_dispatches_the_job_if_filename_is_default_jpg(): void
    {
        $this->doesntExpectJobs(\App\Jobs\DeleteFileJob::class);
        $this->class->dispatchDeleteFileJob('default.jpg');
    }

    /**
     * @author Cho
     * @test
     */
    public function method_clearCache_deletes_3_cache_values(): void
    {
        $cache = ['popular_recipes', 'random_recipes', 'unapproved_notif'];

        array_walk($cache, function ($name) {
            cache()->put($name, str_random(5));
        });

        $this->class->clearCache();

        array_walk($cache, function ($name) {
            $this->assertNull(cache()->get($name));
        });
    }
}
