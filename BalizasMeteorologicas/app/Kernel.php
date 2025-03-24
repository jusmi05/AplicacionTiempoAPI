<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected $commands = [
        \App\Console\Commands\FetchWeatherData::class,
    ];


    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

     protected function schedule(Schedule $schedule)
     {
         // Ejecutar el comando cada hora
         $schedule->command('weather:fetch')->hourly();
     }

}
