<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WipeCommand extends Command
{
    /**
     * The name and signature of the console command
     * @var string
     */
    protected $signature = 'wipe {--main} {--all}';

    /**
     * The console command description
     * @var string
     */
    protected $description = 'This command cleans cache and freshes databese';

    /**
     * Create a new command instance
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('main')) {
            $this->wipeDatabase();
        } else if ($this->option('all')) {
            $this->wipeDatabase();
            $this->changeToTestingDbTable();
            $this->wipeDatabase();
        } else {
            $this->changeToTestingDbTable();
            $this->wipeDatabase();
        }

    }

    /**
     * @return void
     */
    public function wipeDatabase(): void
    {
        $this->info('Chosen database is ' . config('database.connections.mysql.database'));
        $this->call('migrate:fresh');
        $this->call('db:seed');
        $this->info('Database ' . config('database.connections.mysql.database') . ' had been cleared');
    }

    /**
     * @return void
     */
    public function changeToTestingDbTable()
    {
        config()->set('database.connections.mysql', [
            'database' => 'reciper_testing',
        ]);
    }
}
