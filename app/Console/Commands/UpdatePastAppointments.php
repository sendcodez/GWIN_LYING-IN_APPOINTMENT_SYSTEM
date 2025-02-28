<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;

class UpdatePastAppointments extends Command
{
    protected $signature = 'appointments:update-status';
    protected $description = 'Update past appointments with status 1 to status 5';

    public function handle()
    {
        $updated = Appointment::where('status', 1)
            ->whereDate('date', '<', Carbon::today())
            ->update(['status' => 5]);

        $this->info("Updated {$updated} past appointments.");
    }
}
