<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\updateCurrentConditions;
use App\Jobs\updateForeCasts;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\ncr::class,
        // Commands\newModel::class,
        // Commands\nmodule::class,
        // Commands\pushNotificationAfter3Days::class,
        Commands\currentConditions::class,
        Commands\foreCasts::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
	    $schedule->call(function() {
	      updateCurrentConditions::dispatch();
	    })->hourly();

	    $schedule->call(function() {
	      updateForeCasts::dispatch();
	    })->hourly();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
