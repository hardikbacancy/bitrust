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
        '\App\Console\Commands\CronJob',
        '\App\Console\Commands\EmiRemainderJob',
        '\App\Console\Commands\NextEmiRemainderJob',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('CronJob:cronjob')
            ->everyMinute()->withoutOverlapping();

        $schedule->command('EmiRemainderJob:emiRemainderJob')
            ->everyMinute()->withoutOverlapping();

        $schedule->command('NextEmiRemainderJob:nextEmiRemainderJob')
            ->monthlyOn(20, '15:00')->withoutOverlapping();
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
