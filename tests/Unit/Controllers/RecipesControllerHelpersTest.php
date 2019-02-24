<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Helpers\Controllers\RecipeHelpers;

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
     * @test
     */
    public function method_checkForScriptTags_returns_true_if_title_has_script_tag(): void
    {
        $this->withoutNotifications();
        $fields = ['title' => 'Lorem <script ipsum>'];
        $result = $this->class->checkForScriptTags($fields, make(User::class));
        $this->assertTrue($result);
    }

    /**
     * @author Cho
     * @test
     */
    public function method_checkForScriptTags_returns_false_if_title_has_no_script_tag(): void
    {
        $this->withoutNotifications();
        $fields = ['title' => 'Lorem ipsum title'];
        $result = $this->class->checkForScriptTags($fields, make(User::class));
        $this->assertFalse($result);
    }
}
