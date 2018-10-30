<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // At 00:00
        $schedule->job(new \App\Jobs\TopRecipersJob)->dailyAt('00:00');

        // At 03:00
        $schedule->job(new \App\Jobs\DeleteUnactiveUsersJob)->dailyAt('03:00');
        $schedule->job(new \App\Jobs\DeleteNotificationsJob)->dailyAt('19:12');
        $schedule->command('backup:clean')->dailyAt('03:00');
        $schedule->command('backup:run --only-db')->dailyAt('03:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
