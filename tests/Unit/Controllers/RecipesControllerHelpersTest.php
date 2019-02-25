<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Notifications\ScriptAttackNotification;
use App\Models\User;
use App\Helpers\Controllers\RecipeHelpers;

class RecipeControllerHelpersTest extends TestCase
{
    /**
     * @param array $fields
     * @return bool
     */
    private function checkForScriptTags(array $fields): bool
    {
        $class = new class { use RecipeHelpers; };
        return $class->checkForScriptTags($fields, make(User::class));
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
        $this->assertTrue($this->checkForScriptTags(['title' => 'Lorem <script']));
    }

    /**
     * @author Cho
     * @test
     */
    public function method_checkForScriptTags_returns_false_if_title_has_no_script_tag(): void
    {
        $this->withoutNotifications();
        $this->assertFalse($this->checkForScriptTags([
            'title' => 'Lorem ipsum title'
        ]));
    }

    /**
     * @author Cho
     * @test
     */
    public function method_checkForScriptTags_notifies_master_user_about_a_script_attack(): void
    {
        $this->expectsNotification(User::firstUser(), ScriptAttackNotification::class);
        $this->checkForScriptTags(['text' => 'Lorem ipsum title <script> hello']);
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
        $this->checkForScriptTags(['ingredients' => 'Lorem ipsum title <script> hello']);

        $this->assertFileExists(storage_path("logs/laravel-{$date}.log"));
    }
}
