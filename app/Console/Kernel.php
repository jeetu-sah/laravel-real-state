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
        'App\Console\Commands\removeHoldPlots'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('notify:removeholdstatus')->daily()->at('00:00');
        //php artisan backup:clean
        // $schedule->command('cache:clear')->everyMinute();
        // $schedule->command('view:clear')->everyMinute();
        // $schedule->command('config:cache')->everyMinute();
        // $schedule->command('debugbar:clear')->everyMinute();
        // $schedule->command('backup:clean')->everyMinute();
        //php artisan backup:run
        $schedule->command('backup:run')->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
