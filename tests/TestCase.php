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

        $this->app['config']->set('database.connections.mysql', [
            'database' => 'reciper_testing',
        ]);

        if ($this->migrate === true && !static::$migrationsRun) {
            \Artisan::call('wipe');
            static::$migrationsRun = true;
        }
    }
}
