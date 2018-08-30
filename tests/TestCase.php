<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $migrate = false;
    protected static $migrationsRun = false;

    public function setUp()
    {
        parent::setUp();

        if ($this->migrate === true && !static::$migrationsRun) {
            \Artisan::call('wipe', ['test']);
            static::$migrationsRun = true;
        }
    }
}
