<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\TransactionCommand;
use App\Console\Commands\AfCommissionCommand;
use App\Console\Commands\FixTreeCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        TransactionCommand::class,
        AfCommissionCommand::class,
        FixTreeCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Jam 10 Waktu UTC
        $schedule->command('transaction:get')->dailyAt('23:00');
        $schedule->command('af:commission:get')->dailyAt('23:00');
        $schedule->command('af:commission:referral:get')->dailyAt('23:00');
        // $schedule->command('member:fix:tree')->everyTenMinutes();
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
