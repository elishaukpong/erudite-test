<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NotifyParticipantOfEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:notify-participants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Participants notification that event is starting soon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /**
         * send participants notification and
         * mark has_been_notified as true
         */

    }
}
