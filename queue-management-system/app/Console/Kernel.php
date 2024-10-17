<?php

namespace App\Console;

use App\Jobs\SendAppointmentReminder;
use App\Models\Appointment;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $appointments = Appointment::where('start_time', '>', now())
                ->where('start_time', '<', now()->addDay())
                ->get();

            foreach ($appointments as $appointment) {
                SendAppointmentReminder::dispatch($appointment);
            }
        })->dailyAt('08:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}